export default {
    install: function (Vue, options) {
        Vue.prototype.$confirm = (options) => {
            return swal.fire(Object.assign({
                title: 'Tem certeza?',
                text: 'Você não poderá reverter esta ação!',
                type: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                background: '#000',
                backdrop: 'rgba(0,0,0,0.2)',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                customClass: {
                    confirmButton: 'btn m-3',
                    cancelButton: 'btn m-3',
                    title: 'ca-title',
                    container: 'ca',
                },
                padding: '3rem 3rem 2rem',
            }, options));
        };
    },
};