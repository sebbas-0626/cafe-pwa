---
name: Tierra & Grano UI
colors:
  surface: '#fff8f6'
  surface-dim: '#ffcfc4'
  surface-bright: '#fff8f6'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#fff0ed'
  surface-container: '#ffe9e4'
  surface-container-high: '#ffe2db'
  surface-container-highest: '#ffdad2'
  on-surface: '#380c04'
  on-surface-variant: '#55423c'
  inverse-surface: '#542115'
  inverse-on-surface: '#ffede9'
  outline: '#89726b'
  outline-variant: '#dcc1b8'
  surface-tint: '#9b4424'
  primary: '#702506'
  on-primary: '#ffffff'
  primary-container: '#8f3b1c'
  on-primary-container: '#ffbaa3'
  inverse-primary: '#ffb59c'
  secondary: '#006d44'
  on-secondary: '#ffffff'
  secondary-container: '#98f3be'
  on-secondary-container: '#037147'
  tertiary: '#583610'
  on-tertiary: '#ffffff'
  tertiary-container: '#734d25'
  on-tertiary-container: '#f4c08e'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdbcf'
  primary-fixed-dim: '#ffb59c'
  on-primary-fixed: '#390c00'
  on-primary-fixed-variant: '#7c2d0f'
  secondary-fixed: '#9af5c0'
  secondary-fixed-dim: '#7fd9a6'
  on-secondary-fixed: '#002111'
  on-secondary-fixed-variant: '#005232'
  tertiary-fixed: '#ffdcbd'
  tertiary-fixed-dim: '#f0bd8b'
  on-tertiary-fixed: '#2c1600'
  on-tertiary-fixed-variant: '#623f18'
  background: '#fff8f6'
  on-background: '#380c04'
  surface-variant: '#ffdad2'
typography:
  display-lg:
    fontFamily: Epilogue
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Epilogue
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 38px
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Epilogue
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 36px
  headline-lg-mobile:
    fontFamily: Epilogue
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Epilogue
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  price-hero:
    fontFamily: Quicksand
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.03em
  price-hero-mobile:
    fontFamily: Quicksand
    fontSize: 30px
    fontWeight: '700'
    lineHeight: 36px
    letterSpacing: -0.02em
  body-lg:
    fontFamily: Quicksand
    fontSize: 17px
    fontWeight: '600'
    lineHeight: 26px
  body-md:
    fontFamily: Quicksand
    fontSize: 15px
    fontWeight: '500'
    lineHeight: 22px
  label-lg:
    fontFamily: Quicksand
    fontSize: 14px
    fontWeight: '700'
    lineHeight: 18px
    letterSpacing: 0.02em
  label-md:
    fontFamily: Quicksand
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.04em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1rem
  gutter-desktop: 1.5rem
  margin: 1rem
  margin-tablet: 2rem
  margin-desktop: 3rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.25rem
---

## Brand & Style

This design system is crafted specifically for Colombian coffee producers, farm managers, and cooperative members accessing real-time market data directly in the field. 

The aesthetic marries **earthy tactile utilitarianism** with **approachable modern clarity**. It rejects sterile fintech tropes in favor of an organic, sun-warmed editorial look rooted in the Paisa, Cauca, and Huila coffee-growing landscapes: sun-baked parchment, ripe coffee cherries, and fertile shade plantations.

The target user often operates devices in high-glare sunlight, with single-handed thumb navigation, while moving between storage sheds and washing stations. Therefore, interfaces prioritize large interactive tap targets, generous line weights, unambiguous positive cues for price surges, and reassuring tactile feedback that feels solid, dependable, and deeply respectful of the coffee craft.

## Colors

The palette directly references the lifecycle of the coffee bean and its terroir:

- **Primary (`#8F3B1C` - Cereza Madura / Burnt Umber)**: Anchors high-priority actions, primary submit buttons, active segment tabs, and critical CTA paths. It radiates warmth, urgency without alarm, and organic authority.
- **Secondary (`#007046` - Verde Cafetal)**: Utilized for favorable pricing indicators, "Mejor Precio" badges, upward market trends, verified buyer seals, and successful transactional notifications.
- **Tertiary (`#D4A373` - Pergamino Dorado)**: Acts as an enriching accent for secondary chip borders, highlight banners, premium grain grade ratings (Supremo / Excelso), and delicate metric dividers.
- **Neutral Primary (`#44150A` - Café Tostado Oscuro)**: Replaces harsh carbon blacks. Provides AAA-level contrast ratios against creamy backdrops while keeping the overall palette organic and comfortable under harsh daylight.
- **Surface Roles**:
  - `surface-canvas`: `#F5F0E6` (warm, paper-like background that mitigates screen glare).
  - `surface-card`: `#FAF7F2` (soft warm white for elevated modules and list items).
  - `surface-subtle`: `#EADDCB` (recessed inputs, inactive pill indicators, divider lines).
  - `status-alert`: `#B3261E` (coffee rust warning, sudden price drops).

## Typography

The type scale establishes instant readability and unmistakable visual weights.

- **Headings & Display**: Set in **Epilogue**, delivering geometric, bold, grounded authority reminiscent of classic coffee sack stencils and agricultural bulletins, while remaining thoroughly contemporary.
- **Body, Numbers & Units**: Set in **Quicksand**. Its rounded terminals and open apertures offer exceptional clarity for producers reading numbers on the move. When displaying monetary prices (such as `$ COP / @ arroba` or `$ / Carga`), `fontWeight: 700` ensures numbers can never be misread, even at low device brightness.
- **Numerical Formatting**: Currency symbols (`$`) and units (`/@`, `/kg`) are rendered with secondary visual hierarchy (e.g., `label-lg` or `body-md`) adjacent to prominent `price-hero` numerical values to prevent visual congestion.

## Layout & Spacing

Designed as a **mobile-first progressive web application (PWA)**, the layout follows a flexible single-column fluid model on small screens and expands to a maximum 840px structured card canvas on larger tablets or desktop monitors used in cooperative dispatch centers.

- **Margins & Gutters**: Screen margins are preserved at `1rem` (16px) on mobile devices to maximize usable screen real estate, scaling to `2rem` on tablets and `3rem` on desktop displays.
- **Rhythm & Touch Standards**: Vertical element spacing relies on an 8px base rhythm (`space-sm` at 8px, `space-md` at 16px, `space-lg` at 24px). Interactive targets maintain a minimum vertical clearance of 48px to prevent accidental taps when handling devices with gloved or wet hands.

## Elevation & Depth

Visual hierarchy uses **tonal layering infused with warm, ambient earthen shadows**, intentionally avoiding cold synthetic drop shadows or high-gloss glassmorphism.

- **Canvas to Card**: The foundation is `#F5F0E6`. Elements resting on this level are rendered in `#FAF7F2` and defined by a dual-boundary system: a 1px ghost border (`#EADDCB`) paired with a soft, warm-tinted shadow (`0 4px 16px -2px rgba(68, 21, 10, 0.08)`).
- **Interactive Elevated (Floating Controls, Selected Cards)**: Employs an amplified warm shadow (`0 8px 24px -4px rgba(68, 21, 10, 0.12)`) and an active border treatment.
- **Modals & Bottom Drawers**: Lift above the canvas with a directional vertical offset (`0 -8px 32px 0 rgba(68, 21, 10, 0.18)`), accompanied by a dimming warm overlay (`rgba(68, 21, 10, 0.45)`).

## Shapes

The design system embraces generous, friendly curvature to evoke natural forms like coffee berries and smooth river pebbles:

- **Standard Cards & Surfaces**: Use `rounded-lg` (16px / `1rem`), providing a tactile, organic, and friendly shape.
- **Buttons, Inputs & Hero Metrics**: Use 12px to 16px radii, creating a cushion-like, pushable surface.
- **Badges, Filter Pills & Status Chips**: Utilize full pill geometry (`rounded-full` / `9999px`) to maintain immediate differentiation from content cards.
- **Inner Nested Elements**: Strict nested corner harmony is enforced: elements placed inside a 16px card feature 8px or 10px corner radiuses.

## Components

### Buttons
- **Primary Button**: Solid `#8F3B1C` fill with white `#FAF7F2` text, 48px minimum height, 16px corner radius, bold `Quicksand` label. Tap effect features an active compression scale down to 98% and a deepened `#6B2B13` state.
- **Secondary / Cooperative Action**: Transparent fill with a 2px `#8F3B1C` outline, neutral dark text, or solid `#EADDCB` with `#44150A` label for non-primary tools.
- **Verified / Sell Fast**: Secondary button in `#007046` with white text for triggering immediate transaction locks at current market rates.

### Cards & Price Displays
- **Price Quote Card**: Structured with `#FAF7F2` background, 16px rounded corners, and a 1px border of `#EADDCB`. Houses:
  - Top row: Cooperative / Market name and distance badge.
  - Middle: Big numeric price in `price-hero` font weight 700 (`$ 2.450.000`), immediately tagged with unit identifier (`/ Carga 125 kg` or `/ @`).
  - Bottom row: Spread indicator (+2.4% vs. FNC base) in `#007046` with an arrow up icon.
- **Best Price Card**: Distinguishes itself with a 2px outer border in `#007046` and a subtle top banner pill: "MEJOR PRECIO HOY".

### Chips & Badges
- **Status Badges**: Pill-shaped (`rounded-full`), padding `4px 12px`.
  - Positive / Verified: Light tint background (`rgba(0, 112, 70, 0.12)`) with `#007046` text.
  - Coffee Quality Grade: `#D4A373` soft tint with `#44150A` text.
- **Filter Chips**: Toggable pills with `#EADDCB` background, transitioning to `#8F3B1C` with white text when active.

### Inputs & Selectors
- **Unit & Weight Inputs**: Generous 52px height for rapid field entry. Border in 1.5px `#EADDCB`, focused state transitions smoothly to 2px `#8F3B1C` without layout shift.
- **Unit Steppers**: Built-in large +/- stepper buttons on arroba (@) and quintal counters for gloved, one-touch adjustment.

### Lists
- Separated modular rows rather than continuous hairline lines. Each list item functions as an individual mini-card with 12px border radius, 8px vertical gap, and high-contrast trailing chevron indicators.

### Offline & PWA Bar
- Bottom persistent indicator in `#44150A` with warm amber light indicator (`#D4A373`) showing "Precios actualizados (Modo sin conexión)" when the producer loses field cellular connectivity.