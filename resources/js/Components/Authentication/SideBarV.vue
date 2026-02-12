<template>
  <div>
    <v-app-bar color="rgb(0, 73, 128)" prominent>
      <div class="app-bar-content">
        <div class="transition-default">Bienvenue sur Système scolaire!</div>
        <div class="text-end">
          <v-btn
            @click="redirectToWebsite"
            class="text-none"
            style="color: rgb(125, 0, 44); background-color: white"
            rounded
            variant="flat"
            width="90"
          >
            Site web
          </v-btn>
        </div>

      </div>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" permanent>
      <div id="sidebar">
        <div class="sidebar-toggle">
          <div @click.stop="drawer = !drawer" id="btn-toggle">

          </div>
        </div>
        <div class="sidebar-body">
          <div class="sidebar-profile">

            <v-slide-x-transition mode="in-out" leave-absolute>
              <div id="profile-name">
                {{ profileInfo.name }}
              </div>
            </v-slide-x-transition>
          </div>
          <div class="sidebar-links">
            <small>Menu</small>
            <hr class="divider" />
            <div class="links">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link dashboard-link" :class="{active: route().current('dashboard')}">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/profil" class="nav-link profil-link " :class="{active: route().current('profil')}">
                        <i class="bi bi-receipt"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/reports" class="nav-link reports-link" :class="{active: route().current('reports')}">
                        <i class="bi bi-shop"></i>
                        <span>Rapports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/setups" class="nav-link setups-link" :class="{active: route().current('setups')}">
                        <i class="bi bi-people-fill"></i>
                        <span>Configurations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/departments" class="nav-link departments-link" :class="{active: route().current('departements')}">
                        <i class="bi bi-bicycle"></i>
                        <span>Départements</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/analytics" class="nav-link analytics-link" :class="{active: route().current('analytics')}">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pages" class="nav-link employees-link" :class="{active:route().current('pages')}">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>Pages</span>
                    </a>
                </li>
                <li class="nav-item">
                  <a href="/employees" class="nav-link employees-link" :class="{ active: route().current('employees') }">
                        <i class="bi bi-chat-left-dots-fill"></i>
                        <span>Employés</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/settings" class="nav-link settings-link" :class="{ active: route().current('settings') }">
                        <i class="bi bi-gear-fill"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="login.html" class="nav-link">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Déconnexion</span>
                    </a>
                </li>
            </ul>
            </div>
          </div>
        </div>
      </div>
    </v-navigation-drawer>
<FooterComponent />
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";


export default {
  name: "Sidebar",


  data: () => {
    return {
      listGreetings: [
        { id: 1, text: "Wa fonda kayan!" },
        { id: 2, text: "Barka da zouwa!" },
        { id: 3, text: "Bienvenue!" },
        { id: 1, text: "Welcome!" },
        { id: 1, text: "Marhaba!" },
      ],

      drawer: true,
      menuCompact: {
        hidden: true,
      },

      profileInfo: {
        name: "Super Admin",
        photo: {
          file: "team.png",
          title: "photo profile user",
        },
      },
      rail: true,

    };
  },
  mounted() {

  },
  computed: {

  },
  methods: {

    logout() {
      router.post("/logout");
    },
    onClickMenuItem(item) {
      router.get(item);
    },
    redirectToWebsite() {
      router.get("/");
    },
    page(link) {
      router.get(link);
    },
    changeToggleState() {
      let btnToggleIcon = document.getElementById("btn-toggle-icon");
      this.menuCompact.hidden = !this.menuCompact.hidden;

      if (this.menuCompact.hidden) {
        return (btnToggleIcon.style.transform = "rotateY(0deg)");
      } else {
        return (btnToggleIcon.style.transform = "rotateY(180deg)");
      }
    },
  },
};
</script>
<style scoped>
.defile {
  cursor: pointer;

  border-radius: 3px;
}
#sidebar {
  margin: 0;
  top: 0;
  left: 0;
  background-color: rgb(0, 73, 128);
  /* height: 100%; */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.6);
  user-select: none;
}

.sidebar-body {
  flex-grow: 1;
}

.sidebar-profile {
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: left;
  align-items: center;
  margin-block: 15px;
  margin-inline: 14px;
  padding: 4px;
  background-image: linear-gradient(to right, rgb(125, 0, 44, 0.7), rgb(125, 0, 44, 0.4));
  border-radius: 50px;
  border: 2px solid rgb(125, 0, 44, 0.75);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  margin-bottom: 25px;
}

.sidebar-profile:hover {
  background-color: rgba(0, 255, 255, 0.85);
  box-shadow: 0px 0px 8px rgba(0, 255, 255, 0.85);
  transform: scale(1.05);
  cursor: pointer;
}

.sidebar-profile #profile-name {
  font-weight: 900;
  flex-grow: 1;
  font-size: 16px;
  text-align: center;
  color: white;
}

.sidebar-profile img {
  max-width: 60px;
  border-radius: 100%;
  border: 4px inset rgb(125, 0, 44, 0.25);
}

.sidebar-links {
  padding-inline: 15px;
}

.sidebar-links small {
  color: rgba(255, 255, 255, 0.4);
  text-transform: uppercase;
  letter-spacing: 2px;
  font-size: 12px;
}

.divider {
  opacity: 0.25;
  border-radius: 100%;
  margin-bottom: 25px;
}
.sidebar-links .links .v-list {
  display: flex;
  flex-direction: column;
}
.sidebar-links .v-list .list-case {
  cursor: pointer;
  text-decoration: none;
  background-color: rgba(255, 255, 255, 0.75);
  border-radius: 25px;
  padding-inline: 8px;
  padding-block: 8px;
  margin-block: 3px;
  border-width: thick;
  font-weight: 100;
  border: 1px solid rgba(255, 255, 255, 0.85);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.sidebar-links .v-list .list-case:hover {
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 8px rgb(125, 0, 44, 0.85);
  border-color: rgb(125, 0, 44);
  color: white;
}
.sidebar-links .v-list .v-list-group .group-title:hover {
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 8px rgb(125, 0, 44, 0.85);
  border-color: rgb(125, 0, 44);
  color: white;
}
.sidebar-links .v-list .v-list-group .sub-list-group {
  justify-content: flex-start;
  cursor: pointer;
  text-decoration: none;
  margin-left: 35px;
  background-color: rgb(125, 0, 44, 1);
  border-width: thin;
  border-radius: 25px;
  margin-block: 2px;
  color: white;
  font-weight: 80;
  padding-inline: 5px;
  padding-block: 5px;
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  /* border: 1px rgb(125, 0, 44, 1);
    padding-inline: 20px;
  padding-block: 10px;

  */
}
.sidebar-links .v-list .v-list-group .sub-list-group:hover {
  background-color: rgba(255, 255, 255, 0.75);
  color: #000000de;
  font-weight: 100;
}
.sidebar-links .v-list .v-list-group .group-title {
  text-decoration: none;
  background-color: rgba(255, 255, 255, 0.75);
  border-width: thick;
  border-radius: 25px;
  padding-inline: 8px;
  padding-block: 8px;
  margin-block: 3px;
  font-weight: 100;
  border: 1px solid rgba(255, 255, 255, 0.85);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.v-list-group__items {
  background-color: white;
  border-radius: 25px;
  margin-left: 15px;
}
.sidebar-links .icon {
  color: white;
  margin-top: -1px;
  margin-left: 3px;
}
.sidebar-links .icon:hover {
  color: #000000de;
}
.sidebar-toggle {
  top: 0px;
  right: 0px;
}

#btn-toggle {
  background-color: rgba(255, 255, 255, 0.15);
  transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  padding: 5px;
  cursor: pointer;
  display: flex;
  justify-content: center;
}

#btn-toggle:hover {
  background-color: rgb(125, 0, 44, 1);
  box-shadow: 0px 0px 6px aqua;
}

.app-bar-content {
  display: flex;
  align-items: center;
  width: 100%;
  justify-content: space-between;
}

.app-bar-content h2 {
  color: rgba(255, 255, 255, 0.75);
}

.app-bar-content h2:hover {
  color: rgba(255, 255, 255, 1);
}

.transition-default {
  font-family: monospace;
  font-size: 2em;
  animation: color-change 1s infinite;
}

@keyframes color-change {
  0% {
    color: blue;
  }
  10% {
    color: #8e44ad;
  }
  20% {
    color: #1abc9c;
  }
  30% {
    color: #d35400;
  }
  40% {
    color: green;
  }
  50% {
    color: #34495e;
  }
  60% {
    color: orange;
  }
  70% {
    color: #2980b9;
  }
  80% {
    color: #f1c40f;
  }
  90% {
    color: #2980b9;
  }
  100% {
    color: pink;
  }
}
@media screen and (max-width: 600px) {
  .app-bar-content h2 {
    font-size: 18px;
  }
}
</style>
