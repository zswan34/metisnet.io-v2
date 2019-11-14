import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class GodaddyDomainAccounts extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            hasError: false,
            isLoading: true,
        };
    }

    componentDidMount() {

    }

    render() {
        return (
            <h3>Godaddy domains</h3>
        )
    }
}

if (document.getElementById('godaddy-account-wrapper')) {
    ReactDOM.render(<GodaddyDomainAccounts />, document.getElementById('godaddy-account-wrapper'));
}