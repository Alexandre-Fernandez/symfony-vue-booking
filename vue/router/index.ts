import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router"
import HomeView from "../views/HomeView.vue"
import RegisterView from "../views/RegisterView.vue"

const routes: Array<RouteRecordRaw> = [
	{
		path: "/",
		name: "home",
		component: HomeView,
	},
	{
		path: "/register",
		name: "register",
		component: RegisterView,
		meta: {
			public: true,
		},
	},
]

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes,
})

router.beforeEach((to, from) => {
	if (!to.meta?.public) return { name: "register" }
})

export default router
