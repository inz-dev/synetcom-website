<template>
  <div>
    <!-- Sidebar pour écrans larges -->
    <div :class="['sidebar d-flex flex-column flex-shrink-0 p-3 bg-light', { collapsed: isCollapsed }]" style="height: 100vh;">
      <button class="btn btn-sm btn-outline-secondary mb-3" @click="toggleSidebar">
        <i class="bi" :class="isCollapsed ? 'bi-arrow-right-square' : 'bi-arrow-left-square'"></i>
      </button>

      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item" style="font-size: large;">
          <a href="/" class="nav-link home-link" :class="{ active: currentRoute === 'home' }">
            <i class="bi bi-house"></i>
            <span v-if="!isCollapsed"> Accueil</span>
          </a>
        </li>
        <li>
          <a href="/users" class="nav-link users-link" :class="{ active: currentRoute === 'users' }">
            <i class="bi bi-people"></i>
            <span v-if="!isCollapsed"> Utilisateurs</span>
          </a>
        </li>
        <li>
          <a href="/reports" class="nav-link reports-link" :class="{ active: currentRoute === 'reports' }">
            <i class="bi bi-bar-chart"></i>
            <span v-if="!isCollapsed"> Rapports</span>
          </a>
        </li>
        <li>
          <a href="/settings" class="nav-link settings-link" :class="{ active: currentRoute === 'settings' }">
            <i class="bi bi-gear"></i>
            <span v-if="!isCollapsed"> Paramètres</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Navbar pour écrans mobiles -->
    <nav class="navbar navbar-expand-md navbar-light bg-light d-md-none">
      <div class="container-fluid">
        <a class="navbar-brand" href="/"> Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mobileNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a href="/" class="nav-link home-link" :class="{ active: route().current('dashboard') }"> Accueil</a>
            </li>
            <li class="nav-item">
              <a href="/users" class="nav-link users-link" :class="{ active: route().current('users') }"> Utilisateurs</a>
            </li>
            <li class="nav-item">
              <a href="/reports" class="nav-link reports-link" :class="{ active: route().current('reports') }"> Rapports</a>
            </li>
            <li class="nav-item">
              <a href="/settings" class="nav-link settings-link" :class="{ active: route().current('settings') }">Paramètres</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  props: {
    currentRoute: String
  },
  data() {
    return {
      isCollapsed: false
    }
  },
  methods: {
    toggleSidebar() {
      this.isCollapsed = !this.isCollapsed;
    }
  }
}
</script>

<style>
.sidebar {
  width: 250px;
  transition: width 0.3s;
}
.sidebar.collapsed {
  width: 80px;
}
.nav-link.active {
  color: #fff;
}
.nav-link.home-link.active { background-color: #0d6efd; }
.nav-link.users-link.active { background-color: #28a745; }
.nav-link.reports-link.active { background-color: #fd7e14; }
.nav-link.settings-link.active { background-color: #6f42c1; }
</style>
