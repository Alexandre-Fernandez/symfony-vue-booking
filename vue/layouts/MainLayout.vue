<template>
	<header class="flex px-2 py-3">
		<router-link to="/"><h1 class="font-bold">Air-Daisy</h1></router-link>
		<nav class="ml-10">
			<ul class="flex gap-5">
				<router-link to="/housings">Housings</router-link>
			</ul>
		</nav>
	</header>
	<main class="flex justify-center items-center p-6">
		<router-view></router-view>
	</main>
</template>
