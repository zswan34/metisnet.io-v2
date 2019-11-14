import React, { Component } from 'react';

const AUTH_USER_URL = '/api/v1/auth/';

export default class AuthUser extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            hasError: false,
            isLoaded: false,
            authUser: [],
        };
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
    }

    getName() {
        return this.state.authUser.name;
    }

}

