<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.hero_artifact', null);
        $this->migrator->add('site.hero_artifact_label', null);
    }

    public function down(): void
    {
        $this->migrator->delete('site.hero_artifact');
        $this->migrator->delete('site.hero_artifact_label');
    }
};
