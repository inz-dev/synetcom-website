<template>
    <div>
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a class="logo" href="/dashboard">
                    <i class="bi bi-basket2-fill"></i>
                    <span class="logo-text">Synetcom</span>
                </a>
                <button class="menu-toggle" id="menuToggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.html" class="nav-link active">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="order.html" class="nav-link">
                        <i class="bi bi-receipt"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="restaurants.html" class="nav-link">
                        <i class="bi bi-shop"></i>
                        <span>Restaurants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="customer.html" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="riders.html" class="nav-link">
                        <i class="bi bi-bicycle"></i>
                        <span>Delivery Riders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="analytics.html" class="nav-link">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="payments.html" class="nav-link">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>Payments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="reviews.html" class="nav-link">
                        <i class="bi bi-chat-left-dots-fill"></i>
                        <span>Reviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="settings.html" class="nav-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="login.html" class="nav-link">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Login</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content" style="width: 100%">
            <!-- Top Bar -->
            <div class="top-bar">
                <button class="menu-toggle-mobile" id="MenuToggleMobile">
                    <i class="bi bi-list"></i>
                </button>
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        placeholder="Search orders"
                    />
                </div>
            </div>

            <!-- Dashboard Content -->
        </main>
    </div>
</template>
<script setup>
import { onMounted } from "vue";




onMounted(() => {
  console.log("Mounted and DOM ready");

  const menuToggle = document.getElementById("menuToggle");
  const menuToggleMobile = document.getElementById("MenuToggleMobile");
  const sidebar = document.getElementById("sidebar");
  const preview = document.getElementById("preview"); // Assure-toi que cet élément existe

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
        sidebar.classList.remove("mobile-open");
      }
    });
  }

  // Real-time Updates Simulation
  function animateValue(id, start, end, duration) {
    const element = document.getElementById(id);
    if (!element) return;

    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
      current += increment;
      if (
        (increment > 0 && current >= end) ||
        (increment < 0 && current <= end)
      ) {
        current = end;
        clearInterval(timer);
      }
      element.textContent = Math.floor(current); // Affiche la valeur
    }, 16);
  }

  // Navigation
  function showSection(section, event) {
    document.querySelectorAll(".nav-link").forEach((link) => {
      link.classList.remove("active");
    });
    if (event?.target) {
      event.target.closest(".nav-link").classList.add("active");
    }
    console.log("Switching to section:", section);
  }

  // Drag & Drop Preview
  if (preview) {
    preview.addEventListener("dragover", (e) => {
      e.preventDefault();
      preview.classList.add("dragging");
    });

    preview.addEventListener("dragleave", () => {
      preview.classList.remove("dragging");
    });
  }
});
</script>


<style>
:root {
    --primary-color: #ff6b35;
    --primary-dark: #e85a2b;
    --secondary-color: #2ecc71;
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

/* Sidebar */
.sidebar {
    width: 260px;
    height: 100vh;
    background-color: var(--card-bg);
    position: fixed;
    left: 0;
    top: 0;
    border-right: 1px solid var(--border-color);
    overflow-y: auto;
    transition: all 0.3s ease;
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
    color: var(--primary-color);
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
    background-color: var(--primary-color);
    color: white;
}

.nav-link i {
    font-size: 20px;
    width: 24px;
}

.sidebar.collapsed .nav-link span {
    display: none;
}

/* Main Content */
.main-content {
    margin-left: 260px;
    transition: margin-left 0.3s ease;
    min-height: 100vh;
}

.sidebar.collapsed ~ .main-content {
    margin-left: 80px;
}

/* Top Bar */
.top-bar {
    background-color: var(--card-bg);
    border-bottom: 1px solid var(--border-color);
    padding: 16px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 999;
    gap: 5px;
    width: 100vw;
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

.filter-btn {
    padding: 6px 12px;
    background-color: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-secondary);
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-btn:hover,
.filter-btn.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

/* Orders Table */
.table-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
}

.table-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
}

.table-actions {
    display: flex;
    gap: 8px;
}

.order-customer {
    display: flex;
    align-items: center;
    gap: 12px;
}

.customer-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}

.customer-info h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.customer-info p {
    margin: 0;
    font-size: 12px;
    color: var(--text-secondary);
}

.action-buttons {
    display: flex;
    gap: 8px;
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
@media (max-width: 900px) {
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

/* Filter Cards */
.filter-card {
    background: var(--card-bg);
    padding: 20px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.filter-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    border-color: var(--primary-color);
}

.filter-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.filter-info h3 {
    font-size: 2rem;
    font-weight: bold;
    margin: 0;
    color: white;
}

.filter-info p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* Restaurant card styles */
.restaurant-card {
    background: var(--card-bg);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.restaurant-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
    border-color: var(--primary-color);
}

.restaurant-image {
    height: 200px;
    background-size: cover;
    background-position: center;
    position: relative;
}

.status-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    text-transform: uppercase;
    font-size: 0.7rem;
    font-weight: 600;
}

.restaurant-body {
    padding: 20px;
}

.restaurant-name {
    color: white;
    font-weight: bold;
    margin-bottom: 8px;
    font-size: 1.2rem;
}

.restaurant-cuisine {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.restaurant-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}

.restaurant-stats {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 15px;
}

.restaurant-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.restaurant-actions .btn {
    flex: 1;
    min-width: 80px;
}

/* Rider Card Styles */
.rider-card {
    background: var(--card-bg);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.rider-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
    border-color: var(--primary-color);
}

.rider-header {
    background: linear-gradient(135deg, var(--card-bg) 0%, #1f2f4d 100%);
    padding: 30px 20px 20px;
    text-align: center;
    position: relative;
}

.rider-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid var(--primary-color);
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

.login-container {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 500px;
    padding: 20px;
    margin: auto;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 18px;
}
.form-check-label {
    color: #e2e8f0;
    font-size: 14px;
    cursor: pointer;
}
.btn-login {
    width: 100%;
    background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 14px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
}

.btn-login:active {
    transform: translateY(0);
}

@media (max-width: 576px) {
    .login-card {
        padding: 40px 30px;
    }
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
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

.error-icon {
    font-size: 120px;
    color: #ff6b35;
    margin-bottom: 20px;
    animation: bounce 2s ease-in-out infinite;
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
