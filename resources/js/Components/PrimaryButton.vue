<script setup>
defineProps({
    label: { type: String, default: 'Button' },
    disabled: { type: Boolean, default: false },
});
</script>

<template>
    <button
        :disabled="disabled"
        :class="{ 'opacity-25': disabled }"
        class="primary-btn"
    >
        <slot>{{ label }}</slot>
    </button>
</template>

<style scoped>
.primary-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 24px;
    border: none;
    border-radius: 50px;
    background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    font-family: inherit;
}
.primary-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(27,68,156,0.30);
}
.primary-btn:disabled { cursor: not-allowed; }
.opacity-25 { opacity: 0.25; }
</style>
