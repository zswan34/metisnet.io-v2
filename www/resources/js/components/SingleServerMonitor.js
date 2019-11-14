import React, { Component } from 'react';
import ReactDOM from 'react-dom';

let uri = window.location.pathname.split('/').pop();
const SERVER_SERVICE_URL = '/api/v1/servers/' + uri;

export default class SingleServerMonitors extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isFetching: false,
            hasError: false,
            isLoaded: false,
            monitors: [],
            timezone: []
        };
    }

    fetchServers() {
        // Where we're fetching data from
        fetch(SERVER_SERVICE_URL)
        // We get the API response and receive data in JSON format...
            .then(response => response.json())
            // ...then we update the users state
            .then(result =>
                this.setState({
                    isLoaded: true,
                    monitors: result.monitors,
                    timezone: result.timezone,
                    hasError: false
                })
            )
            // Catch any errors we hit and update the app
            .catch(error => this.setState({ error, isLoaded: false, hasError: true }));
    }

    componentDidMount() {
        this.fetchServers();
    }


    render() {
        if (!this.state.hasError) {
            if (!this.state.isLoaded) {
                return (
                    <p className={"italics"}>Loading...</p>
                )
            } else {
                return (
                    <div>
                        <a href="/servers">
                            <i className={"lnr lnr-arrow-left"}></i> Go Back</a>
                        {this.state.monitors.map(function (monitor, index) {
                            let time = moment.unix(monitor.create_datetime).format("dddd, MMMM Do YYYY");
                            let downTime = 100 - Math.floor(monitor.all_time_uptime_ratio);

                            return <div className="h-100 mt-3" key={index}>
                                <div className="d-flex justify-content-between align-items-center mb-5">
                                    <div>
                                        <h2 className="font-weight-light mb-0">{`${ monitor.friendly_name }`}</h2>
                                        <div className="text-muted mb-2">{`${monitor.url}`}</div>
                                        <div className="badge badge-success font-weight-bold">RUNNING</div>
                                    </div>
                                </div>
                                <div className="font-weight-semibold">Up since: {`${time}`}</div>
                                <h5>TODO: add chart.jsx`</h5>
                            </div>
                        })}
                    </div>
                );
            }
        } else {
            return (
                <div className="row">
                    <div className="bg-danger">
                        <p>Unable to connect</p>
                    </div>
                </div>
            );
        }
    }
}


if (document.getElementById('single-server-wrapper')) {
    ReactDOM.render(<SingleServerMonitors />, document.getElementById('single-server-wrapper'));
}