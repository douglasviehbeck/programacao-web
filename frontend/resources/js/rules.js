export default {
    required: function (value, errors) {
        const mensagem = 'O campo é obrigatório';

        try {
            if (value === 0 || value === '0') {
                return;
            }

            if (typeof value !== 'undefined' && value !== null) {
                if (value.trim && !value.trim()) {
                    errors.push(mensagem);
                    return;
                }

                if (Array.isArray(value) && !value.length) {
                    errors.push(mensagem);
                    return;
                }

                if (!value) {
                    errors.push(mensagem);
                    return;
                }
            } else {
                errors.push(mensagem);
                return;
            }
        } catch (e) {
            if (!errors.length) {
                throw e;
            }
        }
    }
}