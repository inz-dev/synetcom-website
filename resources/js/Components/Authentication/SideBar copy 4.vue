<template>
 <div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a class="logo" href="index.html">
                <i class="bi bi-basket2-fill"></i>
                <span class="logo-text">Foodlytix</span>
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
            <li class="nav-item">
                <a href="signup.html" class="nav-link">
                    <i class="bi bi-person-add"></i>
                    <span>Signup</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="forgot-password.html" class="nav-link">
                    <i class="bi bi-eye-fill"></i>
                    <span>Forgot password</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="404.html" class="nav-link">
                    <i class="bi bi-x-circle"></i>
                    <span>404</span>
                </a>
            </li>
             <li class="nav-item">
                <a href="500.html" class="nav-link">
                    <i class="bi bi-x-circle"></i>
                    <span>500</span>
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
                <input type="text" placeholder="Search orders, customers, restaurants...">
            </div>

            <div class="top-bar-actions">
                 <div class="dropdown notify-dropdown">
                      <div class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                       <button class="action-btn">
                            <i class="bi bi-bell-fill"></i>
                            <span class="badge-notification">12</span>
                        </button>
                     </div>

                     <div class="dropdown-menu dropdown-menu-end mt-2">
                        <div id="Notification" class="h-380 scroll-y p-3 custom-scrollbar">
                            <ul class="timeline p-0">
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2">
                                            DR
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Dr Smith uploaded a new report</h6>
                                            <small class="d-block">10 Dec 2023 - 08:15 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-info">
                                            AP
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">New Appointment Scheduled</h6>
                                            <small class="d-block">10 Dec 2023 - 09:45 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-success">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Patient checked in at reception</h6>
                                            <small class="d-block">10 Dec 2023 - 10:20 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2">
                                            AS
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Dr Alice shared a prescription</h6>
                                            <small class="d-block">10 Dec 2023 - 11:00 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-danger">
                                            EM
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Emergency Alert: Critical Patient</h6>
                                            <small class="d-block">10 Dec 2023 - 11:30 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-primary">
                                            <i class="fa fa-calendar-alt"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Next Appointment Reminder</h6>
                                            <small class="d-block">10 Dec 2023 - 12:00 PM</small>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                        </div>
                        <a class="all-notification" href="#">See all notifications <i class="fas fa-arrow-right"></i></a>
                    </div>
                 </div>


                <div class="dropdown notify-dropdown">
                      <div class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                        <button class="action-btn">
                            <i class="bi bi-envelope-fill"></i>
                            <span class="badge-notification">5</span>
                        </button>
                     </div>

                     <div class="dropdown-menu dropdown-menu-end mt-2">
                        <div id="Notification" class="h-380 scroll-y p-3 custom-scrollbar">
                            <ul class="timeline p-0">
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2">
                                            DR
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Dr Smith uploaded a new report</h6>
                                            <small class="d-block">10 Dec 2023 - 08:15 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-info">
                                            AP
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">New Appointment Scheduled</h6>
                                            <small class="d-block">10 Dec 2023 - 09:45 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-success">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Patient checked in at reception</h6>
                                            <small class="d-block">10 Dec 2023 - 10:20 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2">
                                            AS
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Dr Alice shared a prescription</h6>
                                            <small class="d-block">10 Dec 2023 - 11:00 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-danger">
                                            EM
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Emergency Alert: Critical Patient</h6>
                                            <small class="d-block">10 Dec 2023 - 11:30 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 media-primary">
                                            <i class="fa fa-calendar-alt"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-1">Next Appointment Reminder</h6>
                                            <small class="d-block">10 Dec 2023 - 12:00 PM</small>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                        </div>
                        <a class="all-notification" href="#">See all notifications <i class="fas fa-arrow-right"></i></a>
                    </div>
                 </div>
                <div class="dropdown profile-dropdown">
                     <div class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="button">
                         <div class="user-profile">
                            <div class="user-avatar">AD</div>
                            <div class="user-info">
                                <h6>Admin User</h6>
                                <p>Super Admin</p>
                            </div>
                        </div>
                     </div>
                     <ul class="dropdown-menu dropdown-menu-end mt-2">
                         <li><h6 class="dropdown-header">Settings</h6></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-regular fa-user"></i> Profile Settings</a></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-regular fa-bell"></i> Notifications</a></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-solid fa-shield-halved"></i> Privacy &amp; Security</a></li>
                         <li><a class="dropdown-item" href="#"><i class="fa-regular fa-credit-card"></i> Billing</a></li>
                         <li>
                             <div class="sign-out">
                             <a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a>
                             </div>
                         </li>
                     </ul>
                 </div>

            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Dashboard Overview</h1>
                <p>Welcome back! Here's what's happening with your food delivery platform today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> 12%
                        </div>
                    </div>
                    <div class="stat-value" id="totalOrders">1,547</div>
                    <div class="stat-label">Total Orders Today</div>
                    <div class="stat-footer">
                        <i class="bi bi-clock"></i>
                        <span>Updated 5 mins ago</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> 8.5%
                        </div>
                    </div>
                    <div class="stat-value" id="totalRevenue">$24,580</div>
                    <div class="stat-label">Revenue Today</div>
                    <div class="stat-footer">
                        <i class="bi bi-graph-up"></i>
                        <span>vs $22,650 yesterday</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="bi bi-bicycle"></i>
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> 3.2%
                        </div>
                    </div>
                    <div class="stat-value" id="activeRiders">87</div>
                    <div class="stat-label">Active Riders</div>
                    <div class="stat-footer">
                        <i class="bi bi-geo-alt"></i>
                        <span>45 on delivery</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon info">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> 0.3
                        </div>
                    </div>
                    <div class="stat-value">4.8</div>
                    <div class="stat-label">Average Rating</div>
                    <div class="stat-footer">
                        <i class="bi bi-chat-left-dots"></i>
                        <span>From 2,341 reviews</span>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Revenue Analytics</h3>
                            <div class="chart-filters">
                                <button class="filter-btn active">Day</button>
                                <button class="filter-btn">Week</button>
                                <button class="filter-btn">Month</button>
                                <button class="filter-btn">Year</button>
                            </div>
                        </div>
                        <canvas id="revenueChart" height="80"></canvas>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Order Status</h3>
                        </div>
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="table-card">
                <div class="table-header">
                    <h3>Recent Orders</h3>
                    <div class="table-actions">
                        <button class="filter-btn">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <button class="filter-btn">
                            <i class="bi bi-download"></i> Export
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Restaurant</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody >
                <tr>
                    <td><strong>#ORD-2547</strong></td>
                    <td>
                        <div class="order-customer">
                            <div class="customer-avatar">SJ</div>
                            <div class="customer-info">
                                <h6>Sarah Johnson</h6>
                                <p>+1 234 567 8900</p>
                            </div>
                        </div>
                    </td>
                    <td>Pizza Palace</td>
                    <td><strong>$45.80</strong></td>
                    <td>
                        <span class="status-badge delivering">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            Delivering
                        </span>
                    </td>
                    <td>5 mins ago</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-icon-btn" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="action-icon-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="action-icon-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><strong>#ORD-2546</strong></td>
                    <td>
                        <div class="order-customer">
                            <div class="customer-avatar">MC</div>
                            <div class="customer-info">
                                <h6>Michael Chen</h6>
                                <p>+1 234 567 8901</p>
                            </div>
                        </div>
                    </td>
                    <td>Burger House</td>
                    <td><strong>$32.50</strong></td>
                    <td>
                        <span class="status-badge preparing">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            Preparing
                        </span>
                    </td>
                    <td>12 mins ago</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-icon-btn" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="action-icon-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="action-icon-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><strong>#ORD-2545</strong></td>
                    <td>
                        <div class="order-customer">
                            <div class="customer-avatar">ED</div>
                            <div class="customer-info">
                                <h6>Emily Davis</h6>
                                <p>+1 234 567 8902</p>
                            </div>
                        </div>
                    </td>
                    <td>Sushi Master</td>
                    <td><strong>$67.20</strong></td>
                    <td>
                        <span class="status-badge delivered">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            Delivered
                        </span>
                    </td>
                    <td>25 mins ago</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-icon-btn" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="action-icon-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="action-icon-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><strong>#ORD-2544</strong></td>
                    <td>
                        <div class="order-customer">
                            <div class="customer-avatar">JW</div>
                            <div class="customer-info">
                                <h6>James Wilson</h6>
                                <p>+1 234 567 8903</p>
                            </div>
                        </div>
                    </td>
                    <td>Taco Fiesta</td>
                    <td><strong>$28.90</strong></td>
                    <td>
                        <span class="status-badge confirmed">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            Confirmed
                        </span>
                    </td>
                    <td>32 mins ago</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-icon-btn" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="action-icon-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="action-icon-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><strong>#ORD-2543</strong></td>
                    <td>
                        <div class="order-customer">
                            <div class="customer-avatar">LA</div>
                            <div class="customer-info">
                                <h6>Lisa Anderson</h6>
                                <p>+1 234 567 8904</p>
                            </div>
                        </div>
                    </td>
                    <td>Thai Kitchen</td>
                    <td><strong>$54.30</strong></td>
                    <td>
                        <span class="status-badge pending">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            Pending
                        </span>
                    </td>
                    <td>45 mins ago</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-icon-btn" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="action-icon-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="action-icon-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><strong>#ORD-2542</strong></td>
                    <td>
                        <div class="order-customer">
                            <div class="customer-avatar">RB</div>
                            <div class="customer-info">
                                <h6>Robert Brown</h6>
                                <p>+1 234 567 8905</p>
                            </div>
                        </div>
                    </td>
                    <td>Pasta Bar</td>
                    <td><strong>$41.75</strong></td>
                    <td>
                        <span class="status-badge delivered">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            Delivered
                        </span>
                    </td>
                    <td>1 hour ago</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-icon-btn" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="action-icon-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="action-icon-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><strong>#ORD-2541</strong></td>
                    <td>
                        <div class="order-customer">
                            <div class="customer-avatar">JM</div>
                            <div class="customer-info">
                                <h6>Jessica Martinez</h6>
                                <p>+1 234 567 8906</p>
                            </div>
                        </div>
                    </td>
                    <td>BBQ Grill</td>
                    <td><strong>$78.50</strong></td>
                    <td>
                        <span class="status-badge cancelled">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            Cancelled
                        </span>
                    </td>
                    <td>1 hour ago</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-icon-btn" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="action-icon-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="action-icon-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

 </div>

</template>
<script setup>
import { onMounted } from 'vue';

document.addEventListener("DOMContentLoaded", () => {

const totalOrders = document.getElementById("totalOrders");
const totalRevenue = document.getElementById("totalRevenue");
const activeRiders = document.getElementById("activeRiders");

// Sidebar Toggle
const menuToggle = document.getElementById("menuToggle");
const MenuToggleMobile = document.getElementById("MenuToggleMobile");
const sidebar = document.getElementById("sidebar");
// Desktop Menu
// Toggle sidebar on button click
if (menuToggle) {
  menuToggle.addEventListener("click", function (e) {
    e.stopPropagation();
    sidebar.classList.toggle("collapsed");
  });
}

// Mobile Menu
// Toggle sidebar on button click
if (MenuToggleMobile) {
  MenuToggleMobile.addEventListener("click", function (e) {
    e.stopPropagation(); // prevent document click
    sidebar.classList.toggle("mobile-open");
  });
}

// Hide sidebar on outside click
if (sidebar && MenuToggleMobile) {
  document.addEventListener("click", function (e) {
    if (
      sidebar.classList.contains("mobile-open") &&
      !sidebar.contains(e.target) &&
      !MenuToggleMobile.contains(e.target)
    ) {
      sidebar.classList.remove("mobile-open");
    }
  });
}

// Revenue Chart
const revenueChartElement = document.getElementById("revenueChart");
if (revenueChartElement) {
  const revenueCtx = revenueChartElement.getContext("2d");
  let revenueChart = new Chart(revenueCtx, {
    type: "line",
    data: {
      labels: ["6 AM", "9 AM", "12 PM", "3 PM", "6 PM", "9 PM", "12 AM"],
      datasets: [
        {
          label: "Revenue",
          data: [1200, 2800, 5400, 4200, 6800, 5600, 3400],
          borderColor: "#FF6B35",
          backgroundColor: "rgba(255, 107, 53, 0.1)",
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 5,
          pointHoverRadius: 7,
          pointBackgroundColor: "#FF6B35",
          pointBorderColor: "#fff",
          pointBorderWidth: 2,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: "#242837",
          titleColor: "#fff",
          bodyColor: "#a0a4b8",
          borderColor: "#3a3d52",
          borderWidth: 1,
          padding: 12,
          displayColors: false,
          callbacks: {
            label: function (context) {
              return "$" + context.parsed.y.toLocaleString();
            },
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: "#3a3d52",
            drawBorder: false,
          },
          ticks: {
            color: "#a0a4b8",
            callback: function (value) {
              return "$" + value / 1000 + "k";
            },
          },
        },
        x: {
          grid: {
            display: false,
          },
          ticks: {
            color: "#a0a4b8",
          },
        },
      },
    },
  });
}

// Order Status Chart
const orderStatusChartElement = document.getElementById("orderStatusChart");

if (orderStatusChartElement) {
  const statusCtx = orderStatusChartElement.getContext("2d");
  const orderStatusChart = new Chart(statusCtx, {
    type: "doughnut",
    data: {
      labels: ["Delivered", "Delivering", "Preparing", "Pending"],
      datasets: [
        {
          data: [45, 25, 20, 10],
          backgroundColor: ["#2ECC71", "#3498DB", "#9B59B6", "#F39C12"],
          borderWidth: 0,
          hoverOffset: 10,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            color: "#a0a4b8",
            padding: 16,
            font: {
              size: 13,
            },
            usePointStyle: true,
            pointStyle: "circle",
          },
        },
        tooltip: {
          backgroundColor: "#242837",
          titleColor: "#fff",
          bodyColor: "#a0a4b8",
          borderColor: "#3a3d52",
          borderWidth: 1,
          padding: 12,
          callbacks: {
            label: function (context) {
              return context.label + ": " + context.parsed + "%";
            },
          },
        },
      },
    },
  });
}

// Real-time Updates Simulation
function animateValue(id, start, end, duration) {
  const element = document.getElementById(id);
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
    if (id === "totalRevenue") {
      element.textContent = "$" + Math.floor(current).toLocaleString();
    } else if (id === "totalOrders") {
      element.textContent = Math.floor(current).toLocaleString();
    } else {
      element.textContent = Math.floor(current);
    }
  }, 16);
}

// Initialize Dashboard
document.addEventListener("DOMContentLoaded", function () {
  // Animate stat cards

  if (totalOrders) {
    animateValue("totalOrders", 0, 1547, 1000);
  }

  if (totalRevenue) {
    animateValue("totalRevenue", 0, 24580, 1200);
  }

  if (activeRiders) {
    animateValue("activeRiders", 0, 87, 800);
  }

  // Simulate real-time updates
  if (totalOrders) {
    setInterval(() => {
      const currentOrders = parseInt(
        document.getElementById("totalOrders").textContent.replace(",", "")
      );
      animateValue(
        "totalOrders",
        currentOrders,
        currentOrders + Math.floor(Math.random() * 5),
        500
      );
    }, 5000);
  }
});

// Navigation
function showSection(section) {
  // Update active nav link
  document.querySelectorAll(".nav-link").forEach((link) => {
    link.classList.remove("active");
  });
  event.target.closest(".nav-link").classList.add("active");

  // Here you would implement actual section switching
  console.log("Switching to section:", section);
}

// Top Restaurants Chart
const topRestaurantsChartElement = document.getElementById(
  "topRestaurantsChart"
);
if (topRestaurantsChartElement) {
  const topRestaurantsCtx = topRestaurantsChartElement.getContext("2d");
  const topRestaurantsChart = new Chart(topRestaurantsCtx, {
    type: "bar",
    data: {
      labels: [
        "Pizza Palace",
        "Burger Haven",
        "Sushi World",
        "Taco Fiesta",
        "Chinese Garden",
      ],
      datasets: [
        {
          label: "Revenue",
          data: [45890, 38750, 62340, 29450, 41230],
          backgroundColor: [
            "rgba(102, 126, 234, 0.8)",
            "rgba(118, 75, 162, 0.8)",
            "rgba(255, 107, 53, 0.8)",
            "rgba(250, 112, 154, 0.8)",
            "rgba(67, 233, 123, 0.8)",
          ],
          borderRadius: 8,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: "#16213e",
          titleColor: "#fff",
          bodyColor: "#fff",
          borderColor: "#FF6B35",
          borderWidth: 1,
          padding: 12,
          callbacks: {
            label: (context) =>
              "Revenue: $" + context.parsed.y.toLocaleString(),
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: "#a0a0a0",
            callback: (value) => "$" + (value / 1000).toFixed(0) + "k",
          },
          grid: {
            color: "rgba(255, 255, 255, 0.05)",
          },
        },
        x: {
          ticks: {
            color: "#a0a0a0",
          },
          grid: {
            display: false,
          },
        },
      },
    },
  });
}

// Peak Hours Chart

const peakHoursChartElement = document.getElementById("peakHoursChart");
if (peakHoursChartElement) {
  const peakHoursCtx = peakHoursChartElement.getContext("2d");
  const peakHoursChart = new Chart(peakHoursCtx, {
    type: "bar",
    data: {
      labels: ["6AM", "9AM", "12PM", "3PM", "6PM", "9PM", "12AM"],
      datasets: [
        {
          label: "Orders",
          data: [45, 120, 580, 320, 750, 890, 340],
          backgroundColor: "rgba(79, 172, 254, 0.8)",
          borderRadius: 8,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: "#16213e",
          titleColor: "#fff",
          bodyColor: "#fff",
          borderColor: "#FF6B35",
          borderWidth: 1,
          padding: 12,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: "#a0a0a0",
          },
          grid: {
            color: "rgba(255, 255, 255, 0.05)",
          },
        },
        x: {
          ticks: {
            color: "#a0a0a0",
          },
          grid: {
            display: false,
          },
        },
      },
    },
  });
}

const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");

if (togglePassword) {
  togglePassword.addEventListener("click", function () {
    const type =
      password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    this.classList.toggle("bi-eye");
    this.classList.toggle("bi-eye-slash");
  });
}

// Password toggle for confirm password
const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
const confirmPassword = document.getElementById("confirmPassword");

if (toggleConfirmPassword) {
  toggleConfirmPassword.addEventListener("click", function () {
    const type =
      confirmPassword.getAttribute("type") === "password" ? "text" : "password";
    confirmPassword.setAttribute("type", type);
    this.classList.toggle("bi-eye");
    this.classList.toggle("bi-eye-slash");
  });
}

// Gallery images
let galleryImages = [];

const galleryImage = document.getElementById("galleryImages");

if (galleryImage) {
  galleryImage.addEventListener("change", function (e) {
    const files = Array.from(e.target.files);
    files.forEach((file) => {
      const reader = new FileReader();
      reader.onload = function (e) {
        galleryImages.push(e.target.result);
        renderGallery();
      };
      reader.readAsDataURL(file);
    });
  });
}

function renderGallery() {
  const container = document.getElementById("galleryUpload");
  container.innerHTML = "";

  galleryImages.forEach((image, index) => {
    const item = document.createElement("div");
    item.className = "gallery-item";
    item.style.backgroundImage = `url(${image})`;

    const removeBtn = document.createElement("button");
    removeBtn.className = "remove-image";
    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
    removeBtn.onclick = () => removeGalleryImage(index);

    item.appendChild(removeBtn);
    container.appendChild(item);
  });

  const addItem = document.createElement("div");
  addItem.className = "gallery-item add-gallery-item";
  addItem.onclick = () => document.getElementById("galleryImages").click();
  addItem.innerHTML = '<i class="fas fa-plus"></i><p>Add Images</p>';
  container.appendChild(addItem);
}

function removeGalleryImage(index) {
  galleryImages.splice(index, 1);
  renderGallery();
}



  const restaurantImage = document.getElementById("restaurantImage");
  const preview = document.getElementById("imagePreview");

  if (!restaurantImage || !preview) return;

  // Open file dialog when preview is clicked
  preview.addEventListener("click", () => {
    restaurantImage.click();
  });

  // Preview image after selection
  restaurantImage.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
      preview.style.backgroundImage = `url(${event.target.result})`;
      preview.classList.add("has-image");
      preview.innerHTML = ""; // remove icon/text
    };
    reader.readAsDataURL(file);
  });


  preview.addEventListener("dragover", (e) => {
    e.preventDefault();
    preview.classList.add("dragging");
  });

  preview.addEventListener("dragleave", () => {
    preview.classList.remove("dragging");
  });

  preview.addEventListener("drop", (e) => {
    e.preventDefault();
    preview.classList.remove("dragging");

    const file = e.dataTransfer.files[0];
    if (!file) return;

    restaurantImage.files = e.dataTransfer.files;
    restaurantImage.dispatchEvent(new Event("change"));
  });


 const loyalty_tier_card = document.querySelectorAll('.loyalty-tier-card');

 if (loyalty_tier_card) {
   loyalty_tier_card.forEach(card => {
        card.addEventListener('click', function() {
            loyalty_tier_card.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            selectedTier = this.dataset.tier;
        });
    });
 }


});


onMounted(()=>
console.log("")

)
</script>

<style>
 @import url("//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js");
  @import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.bundle.min.js");
@import url("https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js");
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
  font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI",
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
}

.search-bar {
  position: relative;
  width: 400px;
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

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 24px;
  margin-bottom: 32px;
}

.stat-card {
  background-color: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: 12px;
  padding: 24px;
  transition: all 0.3s;
  cursor: pointer;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
  border-color: var(--primary-color);
}

.stat-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 16px;
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
}

.stat-icon.primary {
  background-color: rgba(255, 107, 53, 0.1);
  color: var(--primary-color);
}

.stat-icon.success {
  background-color: rgba(46, 204, 113, 0.1);
  color: var(--success);
}

.stat-icon.warning {
  background-color: rgba(243, 156, 18, 0.1);
  color: var(--warning);
}

.stat-icon.info {
  background-color: rgba(52, 152, 219, 0.1);
  color: var(--info);
}

.stat-trend {
  display: flex;
  align-items: center;
  gap: 4px;
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
}

.stat-trend.up {
  background-color: rgba(46, 204, 113, 0.1);
  color: var(--success);
}

.stat-trend.down {
  background-color: rgba(231, 76, 60, 0.1);
  color: var(--danger);
}

.stat-value {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 8px;
  line-height: 1;
}

.stat-label {
  color: var(--text-secondary);
  font-size: 14px;
  margin-bottom: 12px;
}

.stat-footer {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: var(--text-secondary);
}

/* Chart Cards */
.chart-card {
  background-color: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: 12px;
  padding: 24px;
  margin-bottom: 24px;
}

.chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.chart-header h3 {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.chart-filters {
  display: flex;
  gap: 8px;
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

.custom-table {
  width: 100%;
  border-collapse: collapse;
}

.custom-table thead {
  background-color: var(--dark-bg);
}

.custom-table th {
  padding: 16px 24px;
  text-align: left;
  font-size: 13px;
  font-weight: 600;
  color: var(--text-secondary);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.custom-table td {
  padding: 16px 24px;
  border-top: 1px solid var(--border-color);
  font-size: 14px;
}

.custom-table tbody tr {
  transition: all 0.2s;
}

.custom-table tbody tr:hover {
  background-color: var(--card-hover);
}

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
}

.status-badge.pending {
  background-color: rgba(243, 156, 18, 0.1);
  color: var(--warning);
}

.status-badge.confirmed {
  background-color: rgba(52, 152, 219, 0.1);
  color: var(--info);
}

.status-badge.preparing {
  background-color: rgba(155, 89, 182, 0.1);
  color: #9b59b6;
}

.status-badge.delivering {
  background-color: rgba(52, 152, 219, 0.1);
  color: var(--info);
}

.status-badge.delivered {
  background-color: rgba(46, 204, 113, 0.1);
  color: var(--success);
}

.status-badge.cancelled {
  background-color: rgba(231, 76, 60, 0.1);
  color: var(--danger);
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

/* Loading Animation */
.loading-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid var(--border-color);
  border-top: 3px solid var(--primary-color);
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 20px auto;
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

.rider-status {
  position: absolute;
  top: 15px;
  right: 15px;
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
}

.rider-status.online {
  background: var(--success);
  color: white;
}

.rider-status.busy {
  background: var(--warning);
  color: white;
}

.rider-status.offline {
  background: var(--text-secondary);
  color: white;
}

.rider-body {
  padding: 20px;
}

.rider-name {
  color: white;
  font-weight: bold;
  margin-bottom: 4px;
  font-size: 1.2rem;
}

.rider-id {
  color: var(--text-secondary);
  font-size: 0.85rem;
  margin-bottom: 15px;
}

.rider-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
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

.rider-rating {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.rating-star {
  color: #ffc107;
  font-weight: bold;
}

.rating-reviews {
  color: var(--text-secondary);
  font-size: 0.85rem;
}

.rider-stats {
  display: flex;
  justify-content: space-around;
  padding: 15px 0;
  margin-bottom: 15px;
  background: rgba(255, 255, 255, 0.03);
  border-radius: 10px;
}

.stat-item {
  text-align: center;
}

.stat-value {
  font-size: 1.3rem;
  font-weight: bold;
  color: white;
}

.stat-label {
  font-size: 0.75rem;
  color: var(--text-secondary);
  margin-top: 4px;
}

.rider-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.rider-actions .btn {
  flex: 1;
  min-width: 70px;
}

/* Modal Styles */
.modal-content {
  background: var(--card-bg);
  color: var(--text-primary);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 15px;
}

.modal-header {
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-footer {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-close {
  filter: invert(1);
}

.info-table-wrapper {
  background: linear-gradient(135deg, #0f172a, #1e293b);
  border-radius: 14px;
  padding: 24px;
  color: #e5e7eb;
  max-width: 800px;
}

.info-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.info-table th,
.info-table td {
  padding: 12px 14px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.info-table th {
  text-align: left;
  font-weight: 500;
  color: #cbd5f5;
  width: 35%;
}

.info-table td {
  color: #ffffff;
}

.info-table .section td {
  padding: 14px;
  font-weight: 600;
  color: #ffffff;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 6px;
  border-bottom: none;
}

.info-table .success {
  color: var(--success);
  font-weight: 600;
}

@media (max-width: 576px) {
  .info-table th,
  .info-table td {
    display: block;
    width: 100%;
  }

  .info-table th {
    padding-bottom: 4px;
    color: #94a3b8;
  }

  .info-table td {
    padding-top: 0;
  }
}

/* Adding payment method card styles */
.payment-method-card {
  background: var(--card-bg);
  padding: 20px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  transition: all 0.3s;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.payment-method-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  border-color: var(--primary-color);
}

.payment-method-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: white;
}

.payment-method-info h6 {
  color: var(--text-secondary);
  font-size: 0.85rem;
  margin-bottom: 8px;
  text-transform: uppercase;
  font-weight: 600;
}

.payment-method-info h4 {
  color: white;
  font-size: 1.8rem;
  font-weight: bold;
  margin-bottom: 4px;
}

.payment-method-info p {
  color: var(--text-secondary);
  font-size: 0.9rem;
  margin: 0;
}

/* Rating distribution bars */
.rating-bars {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.rating-bar-item {
  display: flex;
  align-items: center;
  gap: 15px;
}

.rating-label {
  min-width: 60px;
  color: var(--text-primary);
  font-weight: 600;
}

.rating-progress {
  flex: 1;
  height: 25px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 12px;
}

.rating-progress .progress-bar {
  background: linear-gradient(90deg, var(--primary-color) 0%, #ff8f5f 100%);
  border-radius: 12px;
  transition: width 0.5s ease;
}

.rating-count {
  min-width: 40px;
  text-align: right;
  color: var(--text-secondary);
  font-weight: 600;
}

/* Card Styles */
.card {
  background: var(--card-bg);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
  margin-bottom: 20px;
}

.card-header {
  background: transparent;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  padding: 20px;
  color: white;
}

/* Adding review card styles */
.review-card {
  background: var(--card-bg);
  padding: 20px;
  border-radius: 15px;
  transition: all 0.3s;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.review-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  border-color: var(--primary-color);
}

.review-card.flagged {
  border-color: var(--danger);
  border-width: 2px;
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.review-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

.review-rating {
  margin-bottom: 10px;
  font-size: 1.1rem;
}

.review-rating i {
  font-size: 1rem;
}

.review-restaurant {
  color: var(--text-secondary);
  font-size: 0.9rem;
  margin-bottom: 15px;
}

.review-comment {
  color: var(--text-primary);
  line-height: 1.6;
  margin-bottom: 15px;
}

.review-response {
  background: rgba(255, 255, 255, 0.03);
  padding: 15px;
  border-radius: 10px;
  border-left: 3px solid var(--primary-color);
  margin-bottom: 15px;
}

.review-response strong {
  color: var(--primary-color);
  display: block;
  margin-bottom: 8px;
}

.review-response p {
  color: var(--text-secondary);
  margin: 0;
  font-size: 0.9rem;
}

.review-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.review-actions .btn {
  flex: 1;
  min-width: 100px;
}

/* Adding metric card styles for analytics */
.metric-card {
  background: var(--card-bg);
  padding: 20px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  transition: all 0.3s;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.metric-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  border-color: var(--primary-color);
}

.metric-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: white;
}

.metric-info h3 {
  font-size: 2rem;
  font-weight: bold;
  margin: 0;
  color: white;
}

.metric-info p {
  margin: 0 0 8px 0;
  color: var(--text-secondary);
  font-size: 0.9rem;
}

.metric-change {
  font-size: 0.85rem;
  font-weight: 600;
  padding: 4px 8px;
  border-radius: 5px;
}

.metric-change.positive {
  color: #2ecc71;
  background: rgba(46, 204, 113, 0.1);
}

.metric-change.negative {
  color: #e74c3c;
  background: rgba(231, 76, 60, 0.1);
}

.metric-change i {
  font-size: 0.75rem;
}

/* Settings Layout */
.settings-container {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 24px;
}

@media (max-width: 992px) {
  .settings-container {
    grid-template-columns: 1fr;
  }
}

/* Settings Sidebar */
.settings-sidebar {
  background: var(--card-bg);
  border-radius: var(--radius);
  border: 1px solid var(--border);
  box-shadow: var(--shadow);
  overflow: hidden;
  height: fit-content;
}

.settings-nav {
  list-style: none;
  padding: 0;
  margin: 0;
}

.settings-nav-item {
  border-bottom: 1px solid var(--border);
}

.settings-nav-item:last-child {
  border-bottom: none;
}

.settings-nav-link {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 18px 20px;
  color: var(--text);
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.2s ease;
}

.settings-nav-link:hover {
  background: var(--hover);
  color: var(--accent);
}

.settings-nav-link.active {
  background: rgba(var(--accent-rgb, 74, 103, 255), 0.1);
  color: var(--accent);
  border-left: 3px solid var(--accent);
}

.settings-nav-link i {
  font-size: 18px;
  width: 24px;
}

/* Settings Content */
.settings-content {
  background: var(--card-bg);
  border-radius: var(--radius);
  border: 1px solid var(--border-color);
  box-shadow: var(--shadow);
  padding: 32px;
}

.settings-section {
  display: none;
  margin-bottom: 40px;
}

.settings-section.active {
  display: block;
}

.settings-section:last-child {
  margin-bottom: 0;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 1px solid var(--border-color);
}

.section-title {
  font-size: 20px;
  font-weight: 700;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.section-title i {
  color: var(--accent);
}

.section-description {
  color: var(--text-secondary);
  font-size: 14px;
  margin-top: 8px;
}

/* Toggle Switch */
.toggle-switch {
  position: relative;
  display: inline-block;
  width: 52px;
  height: 28px;
  margin-right: 12px;
}

.toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.toggle-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: var(--border-color);
  transition: 0.4s;
  border-radius: 34px;
}

.toggle-slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .toggle-slider {
  background-color: var(--primary-color);
}

input:checked + .toggle-slider:before {
  transform: translateX(24px);
}

.toggle-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  background: var(--card-hover);
  border-radius: 8px;
  margin-bottom: 12px;
  transition: all 0.2s ease;
}

.toggle-item:hover {
  background: var(--border-color);
}

.toggle-info {
  flex: 1;
}

.toggle-title {
  font-weight: 600;
  margin-bottom: 4px;
}

.toggle-description {
  font-size: 13px;
  color: var(--text-secondary);
}

/* Radio Cards */
.radio-cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 12px;
}

.radio-card {
  position: relative;
  padding: 20px;
  background: var(--card-hover);
  border: 2px solid var(--border-color);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.radio-card:hover {
  border-color: var(--border-color);
  transform: translateY(-2px);
}

.radio-card.selected {
  border-color: var(--border-color);
  background: rgba(var(--accent-rgb, 74, 103, 255), 0.1);
}

.radio-card input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.radio-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 12px;
  font-size: 20px;
  background: rgba(var(--accent-rgb, 74, 103, 255), 0.1);
  color: var(--accent);
}

.radio-title {
  font-weight: 600;
  margin-bottom: 4px;
}

.radio-description {
  font-size: 12px;
  color: var(--text-secondary);
}

/* Danger Zone */
.danger-zone {
  border: 1px solid var(--danger);
  border-radius: var(--radius);
  padding: 24px;
  background: rgba(239, 68, 68, 0.05);
}

.danger-title {
  color: var(--danger);
  font-weight: 700;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.danger-description {
  color: var(--text-secondary);
  font-size: 14px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 24px;
  position: relative;
}

.form-control,
.form-select {
  background: var(--dark-bg);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: white;
  border-radius: 8px;
  padding: 12px 16px;
}

.form-control:focus,
.form-select:focus {
  background: var(--dark-bg);
  border-color: var(--primary-color);
  color: white;
  box-shadow: 0 0 10px rgba(255, 107, 53, 0.3);
}

.form-label {
  color: var(--text-secondary);
  font-weight: 500;
}

.form-text {
  font-size: 12px;
  color: var(--text-secondary);
  margin-top: 6px;
}

/* Avatar Upload */
.avatar-upload {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 20px;
}

.avatar-preview {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: var(--card-bg);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 32px;
  font-weight: 700;
  color: var(--text);
  border: 3px solid var(--border-color);
  overflow: hidden;
  position: relative;
}

.avatar-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.avatar-upload-controls {
  flex: 1;
}

.avatar-upload-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  background: var(--primary-color);
  border-radius: 8px;
  border: 1px solid var(--border-color);
  color: var(--text);
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.avatar-upload-btn:hover {
  background: rgba(var(--accent-rgb, 74, 103, 255), 0.1);
}

.avatar-hint {
  font-size: 12px;
  color: var(--text-secondary);
  margin-top: 8px;
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

.btn-group .btn {
  border-color: rgba(255, 255, 255, 0.2);
  color: var(--text-secondary);
}

.btn-group .btn.active,
.btn-group .btn:hover {
  background: var(--primary-color);
  color: white;
  border-color: var(--primary-color);
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

.login-card {
  background: rgba(30, 30, 46, 0.95);
  border-radius: 20px;
  padding: 50px 40px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  animation: slideUp 0.6s ease-out;
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

.logo-section {
  text-align: center;
  margin-bottom: 40px;
}

.logo-icon {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
  border-radius: 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 36px;
  color: white;
  margin-bottom: 20px;
  box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
}

.login-card h2 {
  color: #ffffff;
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 10px;
  text-align: center;
}

.login-card p {
  color: #94a3b8;
  text-align: center;
  margin-bottom: 30px;
}

.form-group {
  margin-bottom: 24px;
  position: relative;
}

.form-label {
  color: #e2e8f0;
  font-weight: 500;
  margin-bottom: 8px;
  font-size: 14px;
}

.form-control {
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 14px 16px;
  color: #ffffff;
  font-size: 15px;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #ff6b35;
  box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
  color: #ffffff;
}

.form-control::placeholder {
  color: #64748b;
}

.input-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 18px;
}

.password-toggle {
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  cursor: pointer;
  font-size: 18px;
  transition: color 0.3s ease;
}

.password-toggle:hover {
  color: #ff6b35;
}

.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.form-check-input {
  background-color: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.2);
  cursor: pointer;
}

.form-check-input:checked {
  background-color: #ff6b35;
  border-color: #ff6b35;
}

.form-check-label {
  color: #e2e8f0;
  font-size: 14px;
  cursor: pointer;
}

.forgot-link {
  color: #ff6b35;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: color 0.3s ease;
}

.forgot-link:hover {
  color: #ff8c5a;
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

.divider {
  display: flex;
  align-items: center;
  text-align: center;
  margin: 30px 0;
}

.divider::before,
.divider::after {
  content: "";
  flex: 1;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.divider span {
  padding: 0 15px;
  color: #64748b;
  font-size: 14px;
}

.social-login {
  display: flex;
  gap: 12px;
  margin-bottom: 30px;
}

.social-btn {
  flex: 1;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 12px;
  color: #e2e8f0;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.social-btn:hover {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
}

.signup-link {
  text-align: center;
  color: #94a3b8;
  font-size: 14px;
}

.signup-link a {
  color: #ff6b35;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

.signup-link a:hover {
  color: #ff8c5a;
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

.form-check-label a {
  color: #ff6b35;
  text-decoration: none;
}

.form-check-label a:hover {
  color: #ff8c5a;
}

.btn-signup {
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

.btn-signup:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
}

.btn-signup:active {
  transform: translateY(0);
}

.login-link {
  text-align: center;
  color: #94a3b8;
  font-size: 14px;
}

.login-link a {
  color: #ff6b35;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

.login-link a:hover {
  color: #ff8c5a;
}

.error-container {
  position: relative;
  z-index: 1;
  text-align: center;
  padding: 40px 20px;
  max-width: 600px;
  animation: fadeIn 0.8s ease-out;
  margin: auto;
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

.error-code {
  font-size: 180px;
  font-weight: 900;
  background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1;
  margin-bottom: 20px;
  text-shadow: 0 0 60px rgba(255, 107, 53, 0.3);
  animation: float 3s ease-in-out infinite;
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

.error-container h1 {
  color: #ffffff;
  font-size: 42px;
  font-weight: 700;
  margin-bottom: 15px;
}

.error-container p {
  color: #94a3b8;
  font-size: 18px;
  line-height: 1.6;
  margin-bottom: 40px;
}

.btn-group {
  display: flex;
  gap: 15px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-primary-custom {
  background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
  color: white;
  border: none;
  border-radius: 12px;
  padding: 14px 32px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-primary-custom:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
}

.btn-secondary-custom {
  background: rgba(255, 255, 255, 0.05);
  color: #e2e8f0;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 14px 32px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-secondary-custom:hover {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
}

@media (max-width: 900px) {
  .error-code {
    font-size: 120px;
  }

  .error-container h1 {
    font-size: 32px;
  }

  .error-container p {
    font-size: 16px;
  }

  .btn-group {
    flex-direction: column;
    align-items: stretch;
  }

  .btn-primary-custom,
  .btn-secondary-custom {
    width: 100%;
    justify-content: center;
  }
}

.image-upload-container {
  text-align: center;
}
.image-preview {
  width: 100%;
  height: 200px;
  border: 2px dashed rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s;
  background-size: cover;
  background-position: center;
}
.image-preview:hover {
  border-color: var(--primary-color);
  background-color: rgba(255, 107, 53, 0.1);
}
.image-preview i {
  font-size: 3rem;
  color: var(--text-secondary);
  margin-bottom: 10px;
}
.image-preview p {
  color: var(--text-secondary);
  margin: 5px 0;
}
.image-preview small {
  color: var(--text-secondary);
  font-size: 0.75rem;
}
.image-preview.has-image i,
.image-preview.has-image p,
.image-preview.has-image small {
  display: none;
}
.gallery-upload {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}
.gallery-item {
  aspect-ratio: 1;
  border-radius: 10px;
  background-size: cover;
  background-position: center;
  position: relative;
  overflow: hidden;
}
.add-gallery-item {
  border: 2px dashed rgba(255, 255, 255, 0.2);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s;
}
.add-gallery-item:hover {
  border-color: var(--primary-color);
  background-color: rgba(255, 107, 53, 0.1);
}
.add-gallery-item i {
  font-size: 1.5rem;
  color: var(--text-secondary);
}
.add-gallery-item p {
  color: var(--text-secondary);
  font-size: 0.8rem;
  margin: 5px 0 0 0;
}
.gallery-item .remove-image {
  position: absolute;
  top: 5px;
  right: 5px;
  width: 25px;
  height: 25px;
  background: var(--danger-color);
  border: none;
  border-radius: 50%;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s;
}
.gallery-item:hover .remove-image {
  opacity: 1;
}

.loyalty-tier {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
}

.loyalty-tier-card {
  flex: 1;
  padding: 16px;
  background: rgba(255, 255, 255, 0.03);
  border: 2px solid rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  color: #fff;
}

.loyalty-tier-card:hover {
  border-color: #ff6b35;
  background: rgba(255, 107, 53, 0.05);
}

.loyalty-tier-card.active {
  border-color: #ff6b35;
  background: rgba(255, 107, 53, 0.1);
}

.loyalty-tier-card i {
  font-size: 1.5rem;
  margin-bottom: 8px;
  display: block;
}

/* Footer */
.footer {
  background-color: var(--card-bg);
  border-top: 1px solid var(--border-color);
  padding: 20px 32px;
  margin-left: 260px;
  transition: margin-left 0.3s ease;
}

.sidebar.collapsed ~ .footer {
  margin-left: 80px;
}

.footer-content {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}

.footer-text {
  display: flex;
  align-items: center;
  gap: 8px;
  color: var(--text-secondary);
  font-size: 14px;
}

.footer-divider {
  color: var(--border-color);
}

@media (max-width: 900px) {
  .footer {
    margin-left: 0;
    padding: 16px;
    text-align: center;
  }

  .footer-content {
    flex-direction: column;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .footer-text {
    flex-direction: column;
    gap: 4px;
  }

  .footer-divider {
    display: none;
  }
}


</style>
