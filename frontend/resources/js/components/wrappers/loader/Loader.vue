<template>
	<div class="v-page-loader">
		<div class="v-page-loader__spinner">
			<svg viewBox="25 25 50 50">
				<circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
			</svg>
		</div>
	</div>
</template>

<script>
    export default {
        name: 'Loader',
    }
</script>

<style scoped>
	.v-page-loader {
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		left: 0;
		background-color: rgba(0, 0, 0, 0.6);
		z-index: 999999999999999999;
		-webkit-box-align: center;
		-ms-flex-align: center;
		align-items: center;
		-webkit-box-pack: center;
		-ms-flex-pack: center;
		justify-content: center;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex
	}

	.v-page-loader__spinner {
		position: relative;
		width: 50px;
		height: 50px
	}

	.v-page-loader__spinner svg {
		-webkit-animation: rotate 2s linear infinite;
		animation: rotate 2s linear infinite;
		-webkit-transform-origin: center center;
		transform-origin: center center;
		width: 100%;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0
	}

	.v-page-loader__spinner svg circle {
		stroke-dasharray: 1, 200;
		stroke-dashoffset: 0;
		-webkit-animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
		animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
		stroke-linecap: round
	}

	@-webkit-keyframes rotate {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg)
		}
	}

	@keyframes rotate {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg)
		}
	}
</style>