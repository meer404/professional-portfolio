<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.name', 'Mir Mohammed');
        $this->migrator->add('site.hero_tagline', [
            'en' => 'Full-Stack Developer — Laravel & bilingual products for Kurdistan',
            'ckb' => '',
        ]);
        $this->migrator->add('site.hero_phrases', [
            'en' => [
                'Full-Stack Laravel Developer',
                'Bilingual (Kurdish / English) products',
                'I turn real problems into working software',
            ],
            'ckb' => [
                'گەشەپێدەری فوڵ-ستاک',
                'بەرهەمی دووزمانە (کوردی / ئینگلیزی)',
                'کێشەی ڕاستەقینە دەکەم بە نەرمەکاڵای کارا',
            ],
        ]);
        $this->migrator->add('site.about_me', [
            'en' => '<p>I\'m a 22-year-old Computer Science graduate based in Sulaymaniyah, Kurdistan Region of Iraq. '
                . 'I build web and desktop software with a focus on bilingual (Kurdish/English) experiences, '
                . 'right-to-left interfaces, and tools that hold up in real day-to-day use.</p>'
                . '<p>My work spans e-commerce, editorial CMS platforms, and offline point-of-sale systems — '
                . 'usually end to end, from database design to deployment and documentation.</p>',
            'ckb' => '',
        ]);
        $this->migrator->add('site.resume_summary', [
            'en' => '<p>Bachelor\'s in Computer Science. Solo and small-team full-stack projects across Laravel, '
                . 'PHP, and Python. Available for freelance and full-time work.</p>',
            'ckb' => '',
        ]);
        $this->migrator->add('site.social_links', [
            ['platform' => 'github', 'label' => 'GitHub', 'url' => 'https://github.com/'],
            ['platform' => 'linkedin', 'label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/'],
            ['platform' => 'email', 'label' => 'Email', 'url' => 'mailto:mirmohammedrashid@gmail.com'],
        ]);
        $this->migrator->add('site.contact_email', 'mirmohammedrashid@gmail.com');
        $this->migrator->add('site.location', [
            'en' => 'Sulaymaniyah, Kurdistan Region, Iraq',
            'ckb' => 'سلێمانی، هەرێمی کوردستان، عێراق',
        ]);
        $this->migrator->add('site.profile_photo', null);
        $this->migrator->add('site.cv_en', null);
        $this->migrator->add('site.cv_ckb', null);
    }
};
