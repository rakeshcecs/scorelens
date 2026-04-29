# ScoreLens — Mobile-First UI/UX QA Report

---

## Overview
ScoreLens is a well-designed, modern landing page with a clean design system. The overall visual identity is strong, the typography is excellent, and the dark/light mode toggle works well. However, there are several **critical functional bugs and UX gaps** that would significantly hurt mobile users. Below is a full breakdown.

---

## 🔴 Critical Issues (Must Fix)

### 1. FAQ Section Is Missing — Broken Navigation Link
The "FAQ" link in the navbar points to `#sl-faq`, but **no section with that ID exists on the page**. Clicking "FAQ" on mobile (via the hamburger menu) leads nowhere. This is a dead link that erodes trust.
- **Fix:** Either build the FAQ section or remove the link from the nav entirely until it's ready.

### 2. "Sign In" Is Inaccessible on Mobile
At ≤860px (mobile breakpoint), the "Sign In" ghost button is hidden via CSS (`display: none`). Critically, it is **not added to the hamburger dropdown menu** either. The hamburger only shows: Features, How it works, Pricing, FAQ — and "Sign In" is completely absent.
- **Fix:** Add a "Sign In" link to the hamburger menu's nav links list.

### 3. Hero Primary CTA Button Text Gets Clipped on Mobile
The primary hero button text reads **"Start free — take a mock test"**. At 390px viewport width (standard iPhone), with both CTA buttons sharing the available space via `flex: 1`, each button gets ~168px. The primary button text needs ~207px at 13px font size. Since the button uses `white-space: nowrap; overflow: hidden`, the text is **silently clipped**.
- **Fix:** Shorten the mobile button label to "Start free →" using a CSS class or `<span>` with visibility toggling, or make the buttons stack vertically on small screens.

### 4. All CTAs Lead to `#` — No Signup Flow
Every CTA button ("Start free — take a mock test", "Take your free mock →", "Start free" on the Free plan) resolves to `#` with no action. There's no email capture form, waitlist, or signup modal. Mobile users who are ready to convert have nowhere to go.
- **Fix:** Implement an email capture form or signup flow. At minimum, a waitlist modal.

---

## 🟠 High Priority Issues

### 5. Hamburger Menu: Nav Links Don't Close the Menu on Click
When a user taps "Features", "Pricing", etc. from the hamburger menu, the menu stays open. Since these are anchor links, the page scrolls but the menu remains covering the content. The user has to manually close it.
- **Fix:** Add a JavaScript listener to close the menu when any nav link is clicked.

### 6. Escape Key Does Not Close the Hamburger Menu
This is a standard keyboard/accessibility behaviour. Pressing `Escape` while the menu is open does nothing.
- **Fix:** Add `document.addEventListener('keydown', ...)` to check for `e.key === 'Escape'` and close the menu.

### 7. Logo Touch Target Is Too Small (149×33px)
Apple's HIG and Google's Material Design both recommend a minimum touch target of **44×44px**. The ScoreLens logo/brand link is 149×33px — the height is only 33px, which is difficult to tap accurately on mobile.
- **Fix:** Add `padding: 6px 0` to `.sl-brand` to bring the height to ≥44px.

### 8. Hero Badge May Overflow on Small Screens
The hero badge "Gain the decisive AI advantage to maximize your score" measures ~351px wide. At 390px viewport with 40px total horizontal padding, only 350px is available. On iPhone SE (320px), this would overflow by ~80px. No mobile-specific size reduction or wrapping rule exists for it.
- **Fix:** Add `max-width: 100%; white-space: normal; text-align: center` for the badge at ≤480px, or shorten the text.

---

## 🟡 Medium Priority Issues

### 9. Nav Links in Hamburger Have No Padding / Touch Targets Too Narrow
The hamburger menu nav links have `padding: 0px`. While their height is 44px (line-height), the widths are very narrow: "FAQ" is only **29px wide**. A fat-finger tap could easily miss it.
- **Fix:** Add `padding: 0 20px` to `.sl-nav-links a` in the mobile nav context, and make each link `display: block; width: 100%` to fill the full menu width.

### 10. No Sticky/Floating Mobile CTA
The page is approximately **~7,500px tall on mobile** (all sections stack into single columns). Once a user scrolls past the hero, there's no persistent "Start free" CTA in view. The sticky header exists, but it only shows "Start free →" — which currently goes to `#` anyway.
- **Fix:** After implementing a real signup flow, consider adding a persistent mobile CTA in the sticky nav or a bottom sticky bar.

### 11. No Scroll-to-Top Button
On a page this long on mobile (~7,500px), there's no way for users to quickly get back to the top.
- **Fix:** Add a simple scroll-to-top button that appears after scrolling ~300px.

### 12. "Coming Soon" Pricing Buttons Give No Feedback
The Pro Monthly and Pro Annual plan buttons say "Coming soon" but are not disabled and provide no user feedback (no tooltip, no modal, no "notify me" option). Mobile users may tap them multiple times thinking they're broken.
- **Fix:** Either disable them (`disabled` attribute + `cursor: not-allowed`) or open a "Notify me" email capture.

### 13. "Terms and Condition" — Grammatical Error in Footer
The footer reads **"Terms and Condition"** instead of "Terms and Conditions".
- **Fix:** Simple copy fix.

---

## 🟢 Positive Observations (What's Working Well)

- **Responsive grid breakpoints are comprehensive** — hero, features, testimonials, pricing, and the analytics section all stack properly into single columns by 960px. The footer collapses correctly at 480px to a single column.
- **Dark mode is functional and well-implemented** — data-theme attribute toggles correctly, and both themes have solid contrast.
- **Hamburger menu animations work** — the bars animate into an X on open, and clicking outside the menu closes it.
- **Typography uses `clamp()`** across headings — the hero H1 scales from 40px (mobile) to 68px (desktop) fluidly. Section headings scale from 32px to 56px. This avoids any jarring text size jumps.
- **Stats section at 767px breaks into 2×2 grid** — appropriate for mobile, numbers remain large and legible.
- **"Designed for" exam badges use `flex-wrap`** — they wrap gracefully on mobile, no horizontal scroll.
- **Sticky header is present** — helps with navigation on the long page.
- **Viewport meta tag is correct** — `width=device-width, initial-scale=1.0` is properly set.
- **Image lazy loading** is implemented on hero and testimonial images.
- **Dark analytics card (Dashboard)** is fully responsive — collapses into a 1-column layout at 960px and has no fixed/min-width that would cause overflow.
- **Scroll-reveal animations** are used for feature cards and steps — adds polish on desktop and still works on mobile.
- **Hero CTA buttons have `flex-wrap: wrap`** — so on very narrow screens they will eventually stack.

---

## Summary Table

| Priority | Issue | Section |
|---|---|---|
| 🔴 Critical | FAQ section missing (broken link) | Navigation |
| 🔴 Critical | Sign In inaccessible on mobile | Navigation |
| 🔴 Critical | Hero primary button text clips on mobile | Hero |
| 🔴 Critical | All CTAs link to `#` — no conversion flow | Site-wide |
| 🟠 High | Hamburger stays open after nav link click | Navigation |
| 🟠 High | Escape key doesn't close hamburger | Navigation |
| 🟠 High | Logo touch target too small (33px height) | Navigation |
| 🟠 High | Hero badge may overflow on small screens | Hero |
| 🟡 Medium | Nav link touch targets too narrow | Navigation |
| 🟡 Medium | No persistent mobile CTA on scroll | Site-wide |
| 🟡 Medium | No scroll-to-top button | Site-wide |
| 🟡 Medium | "Coming soon" buttons give no feedback | Pricing |
| 🟡 Medium | Footer typo: "Terms and Condition" | Footer |

The design language, visual quality, and overall layout are genuinely strong — fixing the critical issues above (especially the missing signup flow and FAQ section) would make this a polished, conversion-ready mobile experience.