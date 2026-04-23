<script setup>
const props = defineProps({
    backgroundImage: String,
    title: String,
});
</script>

<template>
    <section
        class="hero"
        :style="props.backgroundImage ? { '--hero-bg': `url(${props.backgroundImage})` } : {}"
    >
        <!-- Background layers -->
        <div class="hero-bg-img" />
        <div class="hero-overlay" />
        <div class="hero-grid" />

        <!-- Content -->
        <div class="hero-body">
            <div class="hero-eyebrow">
                <span class="eyebrow-dot"></span>
                Transformation Numérique · Niger
            </div>

            <h1 class="hero-title">
                {{ title }}
                <span class="hero-title-accent">.</span>
            </h1>

            <slot />
        </div>

        <!-- Scroll indicator -->
        <div class="scroll-hint">
            <div class="scroll-arrow"></div>
        </div>
    </section>
</template>

<style scoped>
.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding-top: 68px; /* header height */
}

/* Background image */
.hero-bg-img {
    position: absolute;
    inset: 0;
    background-image: var(--hero-bg, url('/images/background1.png'));
    background-size: cover;
    background-position: center;
    transform: scale(1.05);
    transition: transform 8s ease;
}
.hero:hover .hero-bg-img { transform: scale(1.0); }

/* Dark overlay */
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(11,22,56,0.88) 0%,
        rgba(27,68,156,0.72) 60%,
        rgba(11,22,56,0.80) 100%
    );
}

/* Subtle dot grid */
.hero-grid {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
}

/* Content */
.hero-body {
    position: relative;
    z-index: 2;
    max-width: 820px;
    width: 100%;
    padding: 60px 24px;
    text-align: center;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.75);
    margin-bottom: 28px;
    backdrop-filter: blur(8px);
    background: rgba(255,255,255,0.05);
}
.eyebrow-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #f15a2d;
    animation: pulse 2s ease infinite;
}

.hero-title {
    font-size: clamp(2.4rem, 6vw, 4.2rem);
    font-weight: 800;
    line-height: 1.12;
    color: #fff;
    letter-spacing: -0.02em;
    margin: 0 0 8px;
}
.hero-title-accent { color: #f15a2d; }

/* Scroll indicator */
.scroll-hint {
    position: absolute;
    bottom: 36px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    opacity: 0.5;
    animation: bounce 2s ease infinite;
}
.scroll-arrow {
    width: 20px;
    height: 20px;
    border-right: 2px solid #fff;
    border-bottom: 2px solid #fff;
    transform: rotate(45deg);
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(1.4); }
}
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(8px); }
}

@media (max-width: 768px) {
    .hero-body { padding: 40px 20px; }
}
</style>
