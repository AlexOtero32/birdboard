module.exports = {
    theme: {
        extend: {
            colors: {
                grey: {
                    "light-gray": "#F5F6F9"
                }
            },
            boxShadow: {
                default: "0 0 5px 0 rgba(0, 0, 0, .08)"
            }
        },
        backgroundColor: theme => ({
            ...theme("colors"),
            page: 'var(--page-background-color)',
            card: 'var(--card-background-color)',
            button: 'var(--button-background-color)',
            header: 'var(--header-background-color)',
        }),
        textColor: {
            default: 'var(--text-default-color)'
        }
    },
    variants: {}
    ,
    plugins: []
}
;
