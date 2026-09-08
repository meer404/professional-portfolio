# Portfolio Website — Frontend Design Prompt

**Give this to Claude Code when working on the frontend/UI.**

Context: personal portfolio site for a 22-year-old Computer Science graduate (Bachelor's degree), based in Sulaymaniyah, Kurdistan Region of Iraq. Primary language English, secondary Kurdish (Sorani, full RTL). Fully responsive (mobile, tablet, desktop). Built with Laravel + Tailwind CSS + Alpine.js.

## Design goal

Modern and eye-catching, but with a distinctive point of view — not a generic "AI-template" look (gradient-washed hero, identical rounded SaaS cards, ALL-CAPS eyebrow labels, arrow-suffixed buttons, fade-in-on-every-section motion). Every choice below should feel like it was made for this specific developer's story — a Kurdish, bilingual, problem-solving builder — not copy-pasted from any portfolio brief.

## Color (4–6 named values, used with restraint)
- **Ink** `#14121F` — near-black text/background base (not pure black)
- **Paper** `#FAF9FC` — off-white background (not pure white)
- **Signature** `#5B3A9E` — one deep, specific violet; this is the *only* accent color, used sparingly (links, active states, one hero element) — never as a decorative gradient wash
- **Signature-dim** `#8B6FC7` — lighter tint of Signature, for hover/secondary states only
- **Line** `#E4E1EC` — hairline borders/dividers (light mode); `#2A2636` in dark mode
- Dark mode swaps Ink/Paper roles; Signature stays constant so it reads as *his* color in both modes

## Typography
- **Display/headline:** a serif or slab display face with real character — e.g. **Fraunces** (variable, so it can go from soft to sharp) or **Source Serif 4** — used at large sizes for name, section titles, and project titles. This is the one "loud" design element.
- **Body/UI:** a clean sans — e.g. **Inter** or **Public Sans** — for everything else: nav, body copy, form labels, badges
- Kurdish (Sorani) text needs a font that actually supports Arabic script well — pair with **Noto Sans Arabic** or **Vazirmatn** for CKB body text (test rendering; don't assume the Latin font covers it)
- No ALL-CAPS labels, no single-word-highlighted-in-color headlines, no unnecessary "eyebrow" tags above sections

## Layout concept
- Hero is **not** a centered headline-over-gradient. Instead: left-aligned name/tagline on one side, and a real artifact from his work on the other — a cropped screenshot or a short animated code snippet from one of his actual projects (e.g. a bilingual e-commerce platform's RTL toggle in action). This grounds the page in real work from the first second.
- Project cards are **not** identical rounded boxes with matching shadows — vary the emphasis: the featured project gets a larger, asymmetric layout; others are more compact list rows with just title + one-line problem statement + tech badges
- Section dividers are simple hairlines (`Line` color), not decorative gradients or shapes
- Left-aligned body text throughout (not center-aligned blocks of prose) for a more editorial, confident feel

## Profile photo styling
Real headshot photo, not an icon/illustration. Display it inside a rounded frame (circle or squircle) with a thin single-color ring in the Signature violet (`#5B3A9E`, 2-3px, no gradient) and minimal or no drop shadow. Photo should be editable from an admin panel (image upload field), cropped to a square or 4:5 ratio.

## Motion
- One deliberate moment: a subtle reveal on the hero's artifact (screenshot/code snippet) when the page loads — nothing else animates on scroll by default
- Hover states are simple opacity/underline shifts, not scale-and-shadow-pop on every card
- Respect `prefers-reduced-motion`

## What to explicitly avoid
- Gradient backgrounds or gradient text as decoration
- Identical rounded cards with the same soft grey shadow under everything
- "→" appended to button/link text
- Tracked-out ALL-CAPS labels above every section
- Fade-and-slide-up entrance animation repeated on each section
- Generic stock icon sets used decoratively rather than functionally

## Restraint check
Before building, this plan should be reviewed once against the brief: is any part of it something you'd produce for *any* developer portfolio brief, or is it specific to this one? The hero's real-artifact panel and the serif/sans pairing are the two "spend your boldness here" choices — everything else (cards, spacing, badges) should stay quiet and disciplined so those two choices actually stand out.
