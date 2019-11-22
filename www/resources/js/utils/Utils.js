
const AUTH_USER_URL = '/api/v1/auth/';

const AuthUser = () => {
    return (
        fetch(AUTH_USER_URL)
            .then(result =>
                result
            )
            .catch(error => error)
    )
};

export default  AuthUser