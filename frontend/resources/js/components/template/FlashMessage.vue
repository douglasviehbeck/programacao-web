<template>
	
</template>

<script>
    export default {
        name: 'FlashMessage',
		mounted: function() {
			if (window.flashMessages && window.flashMessages.length) {
                window.flashMessages.forEach((message) => {
                    if (message.type === 'error') {
						M.toast({html: message.message, classes: 'red'});
					} else if (message.type === 'success') {
						M.toast({html: message.message, classes: 'green'});
					} else if (message.type === 'warning') {
						M.toast({html: message.message, classes: 'yellow'});
					}
				});
			}
        },
		watch: {
            '$flashMessages': {
                handler: function () {
                    if (this.$flashMessages.messages.length) {
                        this.$flashMessages.messages.forEach((message, index) => {
                            if (message.type === 'error') {
                                M.toast({html: message.message, classes: 'red'});
                            } else if (message.type === 'success') {
                                M.toast({html: message.message, classes: 'green'});
                            } else if (message.type === 'warning') {
                                M.toast({html: message.message, classes: 'yellow'});
                            }
                        });

                        this.$flashMessages.messages = [];
                    }
                },
				immediate: true,
			}
		}
    }
</script>

<style scoped>

</style>