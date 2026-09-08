# Portfolio Website — Build Spec for Claude Code

**Give this entire document to Claude Code as your project prompt.**

---

## 1. Project Overview

Build a personal portfolio website for a 22-year-old Computer Science graduate (Bachelor's degree) based in Sulaymaniyah, Kurdistan Region of Iraq. The site's goal: convince potential clients/employers that this developer can solve real problems, not just list technologies.

- **Primary language:** English
- **Secondary language:** Kurdish (Sorani) — full RTL support
- **Design tone:** Modern, vibrant purple/blue color scheme, clean and tech-forward
- **Devices:** Fully responsive — mobile-first, then tablet, then desktop
- **Admin panel:** Yes — for editing all content without touching code

---

## 2. Tech Stack

- **Laravel 11+**
- **Filament v3** — admin panel
- **spatie/laravel-translatable** — for bilingual (EN/CKB) fields stored as JSON
- **Tailwind CSS** — styling (Filament ships with it; reuse the same config for the public site)
- **Alpine.js** — light interactivity (mobile nav, tabs, modals, scroll reveal)
- **Spatie Media Library** (or Filament's built-in file upload) — for screenshots and CV PDF uploads
- MySQL for the database

---

## 3. Design System

- **Color palette:** vibrant purple/blue gradient theme
  - Primary: a rich indigo/purple (e.g. `#6D28D9` → `#4F46E5` range)
  - Secondary/accent: an electric blue (e.g. `#3B82F6`)
  - Neutral background: near-white in light mode, deep slate in dark mode
  - Include a **dark mode toggle** (Alpine.js + Tailwind `dark:` classes)
- Rounded corners, soft shadows, generous whitespace — avoid a "template" look (see frontend-design principles: intentional typography pairing, no default Bootstrap-like feel)
- Scroll-reveal animations for sections (Intersection Observer via Alpine, or AOS library)
- `dir="rtl"` automatically applied to `<html>` when Kurdish is active; mirror layout, not just text

---

## 4. Database Schema

### `projects` table
| Column | Type | Notes |
|---|---|---|
| id | bigint | |
| title | json (translatable) | |
| slug | string, unique | |
| problem | text (translatable) | The problem the project solves |
| what_i_built | text (translatable) | The solution, in plain terms |
| key_features | json (translatable) | Array of bullet strings |
| tech_stack | json | Array of tech names (not translated — same across languages), rendered as badges |
| my_role | string (translatable) | e.g. "Solo full-stack developer" |
| live_demo_url | string, nullable | |
| github_url | string, nullable | |
| outcome | text (translatable) | Result/impact statement |
| is_public_github | boolean, default true | Hide GitHub button if false |
| featured | boolean, default false | Shows on homepage highlight |
| sort_order | integer | Manual ordering in admin |
| created_at / updated_at | timestamps | |

### `project_screenshots` table (or use Spatie Media Library instead of a custom table)
| Column | Type | Notes |
|---|---|---|
| id | bigint | |
| project_id | foreign key | |
| image_path | string | |
| caption | string (translatable), nullable | |
| sort_order | integer | |

### `skills` table
| Column | Type | Notes |
|---|---|---|
| id | bigint | |
| name | string | e.g. "Laravel" |
| category | string | enum-like: Backend / Frontend / Tools |
| proficiency | integer (0-100) | for a progress bar, optional |
| sort_order | integer | |

### `settings` (or a single-row config table / Filament settings page)
- CV file (English PDF, Kurdish PDF)
- **Profile photo** (image upload — see Section 5 "Hero / Landing" for display styling)
- Social links (GitHub, LinkedIn, email, etc.)
- Hero tagline (translatable)
- About Me text (translatable)

---

## 5. Public Site Structure

### Hero / Landing
- Name, short animated tagline (e.g. "Full-Stack Developer | Laravel Specialist"), profile photo
- CTA buttons: "Download CV" and "View Projects"
- Language switcher (EN/CKB) and dark mode toggle in the navbar

**Profile photo styling:** Real headshot photo, not an icon/illustration. Display it inside a rounded frame (circle or squircle) with a subtle gradient border matching the purple/blue theme (e.g. a 3-4px gradient ring from indigo to electric blue), plus a soft glow/shadow behind it. Store the photo as an image upload field in the Filament settings page (not hardcoded), so it can be replaced anytime from `/admin` without touching code. Recommend cropping to a square or 4:5 ratio on upload (Filament's image editor / Spatie Media Library conversions can auto-generate a cropped, optimized version).

### About Me
- Age, based in Kurdistan Region of Iraq, Bachelor's in Computer Science
- Short narrative about the journey — bilingual/Kurdish-focused development, media work
- Optional: simple timeline component

### Skills
- Grouped by category (Backend / Frontend / Tools), each skill as a badge or progress bar
- Suggested content: PHP, Laravel, Filament, MySQL, REST APIs, Tailwind CSS, JavaScript, Alpine.js, Blade, Git/GitHub, Python, PWA development

### Projects (core section)
Grid of project cards → each opens a **full case-study page** at `/projects/{slug}` with this exact structure:
1. **Problem** — what challenge existed
2. **What I Built** — the solution
3. **Key Features** — bullet list
4. **Tech Stack** — badges
5. **My Role**
6. **Live Demo** button (if `live_demo_url` set)
7. **Screenshots** — gallery/carousel
8. **GitHub** button (only if `is_public_github` is true)
9. **Outcome** — closing impact statement

Suggested seed content (edit freely in admin afterward):

**Project 1 — Bloom & Vine**
- Problem: Small Kurdish businesses lack e-commerce platforms that properly support both Kurdish (RTL) and English in one seamless store.
- What I Built: A full bilingual B2C e-commerce platform with RTL layout, role-based access control, PWA install support, and integrated FIB payment gateway.
- Key Features: RTL/LTR layout switching, role-based access control, installable PWA, secure payment integration
- Tech Stack: PHP, MySQL, Tailwind CSS, Vanilla JavaScript
- My Role: Solo full-stack developer — designed the database, built frontend and backend, authored full technical documentation
- Outcome: Submitted and accepted as university graduation thesis; fully functional bilingual store with live payment integration

**Project 2 — Trilingual News Platform**
- Problem: Kurdish news outlets need a CMS that lets non-technical editors publish in three languages without friction.
- What I Built: A news website with a custom Filament-based admin panel supporting Kurdish, English, and Arabic content.
- Key Features: Multi-language article publishing, custom admin dashboard, clean editorial workflow
- Tech Stack: Laravel, Filament, MySQL
- My Role: Full-stack developer — built the public site and the entire admin panel
- Outcome: Editors can publish and manage content across three languages from a single dashboard

**Project 3 — Offline POS/Cashier System**
- Problem: Small local markets need a reliable point-of-sale system that works fully offline, in Kurdish, with Iraqi Dinar pricing.
- What I Built: A single-PC offline cashier system with barcode scanning, batch-based stock tracking (FIFO/nearest-expiry), and role-based permissions.
- Key Features: Barcode scanning, expiry & batch management, multi-tab sales, customer returns with stock restoration, Kurdish UI
- Tech Stack: Python, SQLite, PyWebView
- My Role: Solo developer — full system design and implementation
- Outcome: A complete offline retail solution tailored to real market operations, with no server or internet dependency

### CV / Resume
- Downloadable PDF button(s) — English and (optionally) Kurdish versions, managed from admin
- Optional: short inline summary of education/experience on the page itself

### Contact
- Contact form (name, email, message) → sent via Laravel Mail to your inbox
- Social links (GitHub, LinkedIn, etc.)

---

## 6. Admin Panel (Filament)

- Single admin user (no public registration)
- **Projects resource:** full form matching the schema above, with a repeater field for `key_features`, a tags/select input for `tech_stack`, translatable tabs (EN/CKB) for translated fields, and a media upload component for screenshots
- **Skills resource:** simple CRUD with category select and proficiency slider
- **Settings page:** CV upload, social links, hero tagline, about text
- Use Filament's built-in translatable plugin support (`filament/spatie-laravel-translatable-plugin`) so each translatable field shows EN/CKB tabs in the form

---

## 7. Localization Notes

- Store translatable content as JSON via `spatie/laravel-translatable` (`title`, `problem`, `what_i_built`, `key_features`, `my_role`, `outcome`, hero tagline, about text)
- `tech_stack` values (e.g. "Laravel", "MySQL") are proper nouns — do not translate
- Use Laravel's locale middleware to switch `app()->setLocale()` based on a session/cookie value set by the language switcher
- Set `dir="rtl"` conditionally on `<html>` based on active locale

---

## 8. Build Order (suggested for Claude Code)

1. Fresh Laravel install + Filament + Tailwind + Alpine setup
2. Migrations & models for `projects`, `skills`, settings
3. Filament resources for Projects and Skills + Settings page
4. Public layout (navbar, language switcher, dark mode toggle, footer)
5. Homepage sections: Hero, About, Skills, Featured Projects, CTA
6. Project index + individual case-study page
7. CV/Resume section + Contact form with mail sending
8. Seed the three example projects above via a database seeder
9. Responsive QA pass (mobile → tablet → desktop) and RTL QA pass
