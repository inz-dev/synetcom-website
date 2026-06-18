<script setup>
import { onMounted, computed, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
const page=usePage()
let user;
if(page.props.auth && page.props.auth.user ){
user=computed(()=>page.props.auth.user)

}
const {lastname, firstname}=user.value
const initialName=firstname[0].toUpperCase()+lastname[0].toUpperCase()
const name=lastname + " "+firstname

const userRoles = computed(() => page.props.auth?.roles ?? [])
const isSuperAdmin = computed(() => userRoles.value.includes('Super-administrateur'))

// Gestion des sous-menus ouverts
const openSubmenus = ref({})
const toggleSubmenu = (id) => {
    openSubmenus.value[id] = !openSubmenus.value[id]
}
const isSubmenuOpen = (item) => {
    if (openSubmenus.value[item.id] !== undefined) return openSubmenus.value[item.id]
    // Auto-ouvrir si une route enfant est active
    return item.children?.some(c => route().current(c.link)) ?? false
}

const allItems=[
    {id:1, title:'Dashboard', link:'dashboard', icon:'bi bi-grid-fill', classActive:'', },
    {id:2, title:'Mon profil', link:'profile', icon:'bi bi-receipt', classActive:'', },
    {id:3, title:'Pages', link:'pages', icon:'bi bi-credit-card-fill', classActive:'', },
    {id:14, title:'Médiathèque', link:'medias', icon:'bi bi-images', classActive:'', },
    {id:4, title:'Configurations', link:'setups', icon:'bi bi-people-fill', classActive:'',},
    {id:5, title:'Départements', link:'departements', icon:'bi bi-bicycle', classActive:'', },
    {id:6, title:'Projets', link:'projects', icon:'bi bi-bar-chart-fill', classActive:'', },
    {
        id:7, title:'Employés', icon:'bi bi-person-badge-fill', classActive:'',
        children: [
            { id:71, title:'Liste des employés', link:'employes', icon:'bi bi-people-fill' },
            { id:72, title:'Réseaux Sociaux', link:'social-medias.index', icon:'bi bi-share-fill' },
        ]
    },
    {id:8, title:'Rapports', link:'reports', icon:'bi bi-shop', classActive:'',},
    {id:12, title:'Opportunités', link:'opportunites-admin', icon:'bi bi-briefcase-fill', classActive:'',},
    {id:13, title:'Organisme', link:'organisme', icon:'bi bi-building-fill', classActive:'',},
    {id:9, title:'Paramètres', link:'settings', icon:'bi bi-gear-fill', classActive:'', },
    {id:10, title:'Utilisateurs', link:'users', icon:'bi bi-people-fill', classActive:'', superAdminOnly: true },
    {id:11, title:'Déconnexion', link:'logout', icon:'bi bi-box-arrow-in-right', classActive:''}
]

const listItems = computed(() =>
    allItems.filter(item => !item.superAdminOnly || isSuperAdmin.value)
)

const activeClass=(vRoute) =>computed(() => {
   return   route().current(vRoute)
})

const logout=() =>router.post('/logout')
onMounted(() => {
  console.log("Mounted and DOM ready:", lastname, firstname,initialName);

  const menuToggle = document.getElementById("menuToggle");
  const menuToggleMobile = document.getElementById("MenuToggleMobile");
  const sidebar = document.getElementById("sidebar");


  // Desktop Menu
  if (menuToggle && sidebar) {
    menuToggle.addEventListener("click", (e) => {
      console.log("Click from MenuToggle:", e);
      e.stopPropagation();
      sidebar.classList.toggle("collapsed");
    });
  }

  // Mobile Menu
  if (menuToggleMobile && sidebar) {
    menuToggleMobile.addEventListener("click", (e) => {
      e.stopPropagation();
      sidebar.classList.toggle("mobile-open");
    });

    // Hide sidebar on outside click
    document.addEventListener("click", (e) => {
      if (
        sidebar.classList.contains("mobile-open") &&
        !sidebar.contains(e.target) &&
        !menuToggleMobile.contains(e.target)
      ) {
        console.log('mobile open')
        sidebar.classList.remove("mobile-open");
      }
      console.log('no mobile open')
    });
  }


});
</script>
<template>
    <div>
        <!-- Sidebar -->

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a class="logo" href="/dashboard">

                    <span class="logo-text">Synetcom</span>
                </a>
                <button class="menu-toggle" id="menuToggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <ul class="nav-menu">
                <li class="nav-item" v-for="item in listItems" :key="item.id">

                    <!-- Item avec sous-menu -->
                    <template v-if="item.children">
                        <a class="nav-link nav-link--parent"
                           :class="{ active: item.children.some(c => route().current(c.link)) }"
                           @click="toggleSubmenu(item.id)"
                           style="cursor:pointer">
                            <i :class="item.icon"></i>
                            <span>{{ item.title }}</span>
                            <i class="bi bi-chevron-down submenu-arrow"
                               :class="{ 'submenu-arrow--open': isSubmenuOpen(item) }"></i>
                        </a>
                        <ul v-show="isSubmenuOpen(item)" class="submenu">
                            <li v-for="child in item.children" :key="child.id" class="submenu-item">
                                <a :href="route(child.link)" class="submenu-link"
                                   :class="{ active: route().current(child.link) }">
                                    <i :class="child.icon"></i>
                                    <span>{{ child.title }}</span>
                                </a>
                            </li>
                        </ul>
                    </template>

                    <!-- Déconnexion -->
                    <a v-else-if="item.title=='Déconnexion'" class="nav-link" @click="logout">
                        <i :class="item.icon"></i>
                        <span>{{ item.title }}</span>
                    </a>

                    <!-- Item simple -->
                    <a v-else :href="item.link" class="nav-link" :class="{active: route().current(item.link)}">
                        <i :class="item.icon"></i>
                        <span>{{ item.title }}</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
         <main class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <button class="menu-toggle-mobile" id="MenuToggleMobile">
                <i class="bi bi-list"></i>
            </button>

            <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Rechercher...">
            </div>

            <div class="top-bar-actions">
                 <div class="dropdown notify-dropdown">
                      <div class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                       <button class="action-btn">
                            <i class="bi bi-bell-fill"></i>
                            <span class="badge-notification">12</span>
                        </button>
                     </div>


                 </div>


                <div class="dropdown notify-dropdown">
                      <div class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                        <button class="action-btn">
                            <i class="bi bi-envelope-fill"></i>
                            <span class="badge-notification">5</span>
                        </button>
                     </div>
                 </div>
                <div class="dropdown profile-dropdown">
                     <div class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                         <div class="user-profile">
                            <div class="user-avatar">{{ initialName }}</div>
                            <div class="user-info">
                                <h6>{{ name }}</h6>
                                <p><small>Super Admin</small></p>
                            </div>
                        </div>
                     </div>
                     <ul class="dropdown-menu dropdown-menu-end mt-2">
                         <li><h6 class="dropdown-header">Settings</h6></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-regular fa-user"></i> Mes Paramètres</a></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-regular fa-bell"></i> Notifications</a></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-solid fa-shield-halved"></i> Confidentialité &amp; Sécurit</a></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-regular fa-credit-card"></i>Payements</a></li>
                         <li>
                             <div class="sign-out">
                                 <button class="dropdown-item text-danger" @click="logout">
                                     <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                                 </button>
                             </div>
                         </li>
                     </ul>
                 </div>

            </div>
        </div>

        <!-- Dashboard Content -->
        <slot/>
        <br> <br>
<FooterComponent />
    </main>

    </div>
</template>



<style>
:root {
    --primary-color:  #1b449c ;
    --primary-dark: #e85a2b;
    --secondary-color: #f15a2d ;
    --dark-bg: #1a1d29;
    --card-bg: #242837;
    --card-hover: #2d3142;
    --text-primary: #ffffff;
    --text-secondary: #a0a4b8;
    --border-color: #3a3d52;
    --success: #2ecc71;
    --warning: #f39c12;
    --danger: #e74c3c;
    --info: #3498db;
    --shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    --radius: 12px;
    --gap: 18px;
    --accent: #ff6b35;
    --accent-rgb: 59, 130, 246;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family:
        "Inter",
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;
    background-color: var(--dark-bg);
    color: var(--text-primary);
    overflow-x: hidden;
}
ul{
    height: 50px;
}
/* Sidebar */
.sidebar {
    width: 260px;
    height: calc(100% - 25px);
    background-color: var(--card-bg);
    position: fixed;
    left: 0;
    top: 0;
    border-right: 1px solid var(--border-color);
    overflow-y: auto;
    transition: all 1s ease;
    z-index: 1000;
}

/* Scrollbar width */
.sidebar::-webkit-scrollbar {
    width: 7px;
}

/* Track */
.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

/* Thumb */
.sidebar::-webkit-scrollbar-thumb {
    background-color: var(--dark-bg);
    border-radius: 10px;
}

/* Hover effect */
.sidebar::-webkit-scrollbar-thumb:hover {
    background-color: var(--card-hover);
}

.sidebar.collapsed {
    width: 80px;
}

.sidebar-header {
    padding: 18px 15px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 24px;
    font-weight: 700;
    color: var(--secondary-color);
    text-decoration: none;
}

.logo i {
    font-size: 32px;
}

.sidebar.collapsed .logo-text {
    display: none;
}

.menu-toggle,
.menu-toggle-mobile {
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 20px;
    cursor: pointer;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.2s;
}

.menu-toggle:hover,
.menu-toggle-mobile:hover {
    background-color: var(--card-hover);
    color: var(--text-primary);
}

.nav-menu {
    list-style: none;
    padding: 16px 12px;
}

.nav-item {
    margin-bottom: 4px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
    font-size: 14px;
    font-weight: 500;
}

.nav-link:hover {
    background-color: var(--card-hover);
    color: var(--text-primary);
}

.nav-link.active {
    background-color: var(--secondary-color);
    color: white;
}

.nav-link i {
    font-size: 20px;
    width: 24px;
}

.sidebar.collapsed .nav-link span {
    display: none;
}

/* Sous-menu */
.nav-link--parent {
    position: relative;
    justify-content: space-between;
}

.submenu-arrow {
    font-size: 12px !important;
    width: auto !important;
    margin-left: auto;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.submenu-arrow--open {
    transform: rotate(180deg);
}

.submenu {
    list-style: none;
    padding: 4px 0 4px 12px;
    margin: 0;
    border-left: 2px solid var(--border-color);
    margin-left: 28px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.submenu-item {
    margin-bottom: 2px;
}

.submenu-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
}

.submenu-link i {
    font-size: 16px;
    width: 20px;
}

.submenu-link:hover {
    background-color: var(--card-hover);
    color: var(--text-primary);
}

.submenu-link.active {
    background-color: rgba(241, 90, 45, 0.15);
    color: var(--secondary-color);
}

.sidebar.collapsed .submenu {
    display: none;
}

.sidebar.collapsed .submenu-arrow {
    display: none;
}

/* Main Content */
.main-content {
    margin-top: 100px;
    margin-left: 260px;
    transition: margin-left 1s ease-in-out;
}

.sidebar.collapsed ~ .main-content {
    margin-left: 80px;
}

/* Top Bar */
.top-bar {
    background-color: var(--card-bg);
    border-bottom: 1px solid var(--border-color);
    padding: 18px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position:fixed;
    top: 0;
    left:0;
    z-index: 999;
    gap:5px;
    width: 100%;
}

.search-bar {
    position: relative;
    width: 200px;
}

.search-bar input {
    width: 100%;
    padding: 10px 16px 10px 44px;
    background-color: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 14px;
}

.search-bar input:focus {
    outline: none;
    border-color: var(--primary-color);
}

.search-bar i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}

.top-bar-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    width:300px;
}

.action-btn {
    position: relative;
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 20px;
    padding: 8px;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.2s;
}

.action-btn:hover {
    background-color: var(--card-hover);
    color: var(--text-primary);
}

.badge-notification {
    position: absolute;
    top: 4px;
    right: 4px;
    background-color: var(--danger);
    color: white;
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 10px;
    font-weight: 600;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s;
}

.user-profile:hover {
    background-color: var(--card-hover);
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        var(--primary-color),
        var(--primary-dark)
    );
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.user-info h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.user-info p {
    margin: 0;
    font-size: 12px;
    color: var(--text-secondary);
}

/* Dashboard Content */
.dashboard-content {
    padding: 32px;
}

.page-header {
    margin-bottom: 32px;
}

.page-header h1 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 8px;
}

.page-header p {
    color: var(--text-secondary);
    margin: 0;
}

.action-icon-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
}

.action-icon-btn:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.menu-toggle-mobile {
    display: none;
}

/* Responsive */
@media (max-width: 1000px) {
    .menu-toggle-mobile {
        display: block;
    }

    .menu-toggle {
        display: none;
    }

    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.mobile-open {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
    }

    .search-bar {
        width: 200px;
    }

    .user-info {
        display: none;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-content {
        padding: 16px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .top-bar {
        padding: 16px 10px;
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}


.status-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    text-transform: uppercase;
    font-size: 0.7rem;
    font-weight: 600;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.info-item i {
    color: var(--primary-color);
    width: 20px;
}

/* Card Styles */
.card {
    background: var(--card-bg);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    margin-bottom: 20px;
}

@media (max-width: 992px) {
    .settings-container {
        grid-template-columns: 1fr;
    }
}

.form-text {
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 6px;
}

/* Button Styles */
.btn {
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary {
    background: var(--primary-color);
    border: none;
}

.btn-primary:hover {
    background: #ff8f5f;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
}

.btn-outline-primary {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: white;
}

.btn-outline-success {
    border-color: var(--success);
    color: var(--success);
}

.btn-outline-success:hover {
    background: var(--success);
    color: white;
}

.btn-outline-danger {
    border-color: var(--danger);
    color: var(--danger);
}

.btn-outline-danger:hover {
    background: var(--danger);
    color: white;
}

.btn-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    padding: 10px 20px;
    border-radius: 10px;
    color: var(--danger);
    font-weight: 600;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.btn-danger:hover {
    background: rgba(239, 68, 68, 0.2);
    transform: translateY(-2px);
    color: var(--danger);
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.scroll-y {
    overflow-y: auto;
}

.h-380 {
    height: 380px;
}

.dropdown-toggle::after {
    display: none !important;
}

.notify-dropdown .dropdown-menu {
    background: var(--card-bg);
    color: var(--text-primary);
}

.notify-dropdown .timeline {
    list-style: none;
    width: 250px;
}

.notify-dropdown .timeline .timeline-panel {
    display: flex;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.notify-dropdown .timeline .timeline-panel .media {
    width: 45px !important;
    height: 45px !important;
    font-size: 18px !important;
    border-radius: 12px;
    overflow: hidden;
    font-size: 20px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    align-self: start;
    background: var(--dark-bg);
}

.notify-dropdown .media-body {
    flex: 1;
}

.notify-dropdown .all-notification {
    display: block;
    padding: 0.7rem;
    text-align: center;
    border-top: 1px solid var(--border-color);
    color: var(--accent);
    text-decoration: none;
}

.notify-dropdown .marker {
    position: absolute;
    top: 0px;
    right: 0px;
    width: 11px;
    height: 11px;
    border-radius: 50%;
    animation: pulse 1s ease-out infinite;
}

@keyframes pulse {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1);
        opacity: 0.5;
    }
    100% {
        transform: scale(0);
        opacity: 0;
    }
}

.profile-dropdown .dropdown-menu {
    background-color: var(--card-bg);
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.profile-dropdown .dropdown-header {
    font-weight: 600;
    font-size: 1rem;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    padding: 0.75rem;
}

.profile-dropdown .dropdown-item {
    padding: 0.65rem 1.5rem;
    color: var(--text-primary);
}

.profile-dropdown .dropdown-item:hover {
    background-color: var(--card-hover);
    color: var(--primary-color);
}

.profile-dropdown .dropdown-item i {
    margin-right: 8px;
    font-size: 1.1rem;
}

.profile-dropdown .sign-out {
    border-top: 1px solid var(--border-color);
    text-align: center;
    padding: 4px 0;
}


@media (max-width: 576px) {
    .login-card {
        padding: 40px 30px;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}


@keyframes bounce {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-15px);
    }
}
</style>
