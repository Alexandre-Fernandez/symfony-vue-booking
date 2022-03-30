<script lang="ts">
import { computed, defineComponent } from "vue"
import { useRoute } from "vue-router"
import MainLayout from "./layouts/MainLayout.vue"

export default defineComponent({
	components: {
		MainLayout,
	},
	setup() {
		const route = useRoute()
		const currentLayout = computed(
			() => (route.meta?.layout as string) || "MainLayout"
		)
		return {
			currentLayout,
		}
	},
})
</script>

<template>
	<div>
		<component :is="currentLayout" />
	</div>
</template>
