import React, { Component } from 'react';
import ReactTooltip from 'react-tooltip'
import EclipseElementLoadingComponent from "../loading/EclipseElementLoadingComponent";

const USER_API_URL = '/api/v1/users/';

export default class AccountUserActivity extends Component {
    constructor(props) {
        super(props);
        this.state = {
            errors: null,
            activities: [],
            isLoaded: false,
            hasError: false,
            user: this.props.user,
            authUser: this.props.authUser
        }
    }

    fetchActivities() {
        fetch(USER_API_URL + this.props.user.uid + '/activity?limit=10')
            .then(response => response.json())
            .then(result =>
                this.setState({
                    activities: result,
                    isLoaded: true
                })
            )
            .catch(error => this.setState({ errors: error, isLoaded: false, hasError: true }));
    }

    componentDidMount() {
        this.fetchActivities()
    }

    updateActivities() {
        this.setState({
            isLoaded: false
        });
        this.fetchActivities();
    }

    render() {

        if (this.state.isLoaded) {
            return (
                <div style={{position: 'relative'}}>
                    <ReactTooltip/>
                    <span className={"text-primary"} onClick={this.updateActivities.bind(this)} data-tip="Refresh"
                          style={{cursor: 'pointer', position: 'absolute', top: '-40px', right: '0px'}}>
                        <i className={"ion ion-md-refresh"}></i>
                            </span>
                {this.state.activities.map((activity, index) => {
                    let timeAgo = moment(activity.created_at);

                    if (timeAgo.diff(moment(), 'days') > 2) {
                        timeAgo = moment.tz(activity.created_at, activity.timezone).format('dddd, MMMM Do YYYY');
                    } else {
                        timeAgo = moment.tz(activity.created_at, activity.timezone).fromNow();
                    }

                    let bg = '';
                    let icon = 'ion ion-ios-list-box';
                    let html = '';
                    if (activity.log_name === 'auth') {
                        bg = 'bg-success';
                        icon = 'ion ion-md-unlock';
                        html = <small className="text-body">
                                    <div>Client IP: {activity.properties.session.ip_address}</div>
                                    <div>Browser: {activity.properties.session.browser}</div>
                                    <div>OS: {activity.properties.session.platform}</div>
                                </small>;
                    }

                    if (activity.log_name === 'auth-failed') {
                        bg = 'bg-danger';
                        icon = 'ion ion-md-lock';
                        html = <small className="text-body">
                                    <div>Client IP: {activity.properties.session.ip_address}</div>
                                    <div>Browser: {activity.properties.session.browser}</div>
                                    <div>OS: {activity.properties.session.platform}</div>
                                </small>;
                    }

                    if (activity.log_name === 'user-created') {
                        bg = 'bg-info';
                        icon = 'ion ion-md-person-add';
                    }

                    return (
                        <div className="media pb-1 mb-3" key={index}>
                            <div className={"account-activity-category " + bg}>
                                <span className={icon}></span>
                            </div>
                            <div className="media-body ml-3">
                                <div className="mb-1">
                                    <strong className="font-weight-semibold">{activity.description}</strong> &nbsp;
                                    <small className="text-muted">{ timeAgo }</small>
                                </div>
                                {html}
                            </div>
                        </div>
                    )
                })}
                </div>
            )
        } else {
            return (
                <EclipseElementLoadingComponent/>
            )
        }
    }
}