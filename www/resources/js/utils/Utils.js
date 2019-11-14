import React from 'react';

const AUTH_USER_URL = '/api/v1/auth/';

class Utils {
    constructor(props) {
        this.state = {
            error: null,
            hasError: false,
            isLoaded: false,
            authuser: [],
        }
    }

    fetchAuthUser() {
        fetch(AUTH_USER_URL)
            .then(response => response.json())
            .then(result =>
                this.setState({
                    authUser: result.auth
                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    componentDidMount() {
        this.fetchAuthUser();
        console.log(this.state.authuser);
    }

    userHasPermission(permission) {
        const permissions = this.state.authUser.permissions;
        let match = false;
        for(let i = 0; i < permissions.length; i++) {
            if (permissions[i].name === permission) {
                match = true;
            }
        }
        return match;
    }
}

export default Utils;
