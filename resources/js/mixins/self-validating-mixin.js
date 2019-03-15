export default {
    props: {
        rules: {
            default: []
        }
    },
    data: function () {
        return {
            errors: []
        };
    },
    methods: {
        validate: function () {
            this.errors = [];

            this.rules.forEach((rule) => {
                if (!this.$rules[rule]) {
                    throw new Error('Regra "' + rule + '" não existe');
                }

                this.$rules[rule](this.value, this.errors);
            });
        }
    }
}