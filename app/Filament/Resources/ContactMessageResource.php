<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::whereNull('read_at')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make()
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('name'),
                    Infolists\Components\TextEntry::make('email')->copyable(),
                    Infolists\Components\TextEntry::make('created_at')->dateTime(),
                    Infolists\Components\TextEntry::make('read_at')->dateTime()->placeholder('Unread'),
                    Infolists\Components\TextEntry::make('message')->columnSpanFull()->prose(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\IconColumn::make('read_at')
                    ->label('Read')
                    ->boolean()
                    ->getStateUsing(fn (ContactMessage $record): bool => $record->read_at !== null),

                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('message')->limit(60)->wrap(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('unread')
                    ->query(fn (Builder $query): Builder => $query->whereNull('read_at'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->after(fn (ContactMessage $record) => $record->read_at ?? $record->forceFill(['read_at' => now()])->save()),
                Tables\Actions\Action::make('toggleRead')
                    ->label(fn (ContactMessage $record): string => $record->read_at ? 'Mark unread' : 'Mark read')
                    ->icon('heroicon-m-eye')
                    ->action(fn (ContactMessage $record) => $record->forceFill([
                        'read_at' => $record->read_at ? null : now(),
                    ])->save()),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markRead')
                        ->icon('heroicon-m-check')
                        ->action(fn ($records) => $records->each->forceFill(['read_at' => now()])->each->save())
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
