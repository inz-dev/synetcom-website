<script setup></script>

<template>
    <footer class="footer">
        <small
            >&copy;{{ new Date().getFullYear() }}&nbsp; Copyright:
            <a class="link-site" href="http://127.0.0.1:8000/"
                >Synetcom-niger</a
            >
            - Tous droits réservés</small
        >
    </footer>
</template>

<style>
.link-site {
    text-decoration: none;

    color: black;
}
.link-site:hover {
    color: #1b449c;
}
.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
    color: white;
    text-align: center;

}
</style>
