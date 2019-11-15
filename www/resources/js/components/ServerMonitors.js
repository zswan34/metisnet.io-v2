import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ErrorComponent from "./errors/ErrorComponent";
import StandardLoadingComponent from "./loading/StandardLoadingComponent";

const SERVER_SERVICE_URL = '/api/v1/servers';

export default class ServerMonitors extends Component {
    constructor(props) {
        super(props);
        this.state = {
            errors: null,
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
            .catch(error => this.setState({ errors: error, isLoading: false, hasError: true }));
    }

    componentDidMount() {
        this.fetchServers();
    }

    refreshData() {
        this.fetchServers();
    }

    render() {
            if (!this.state.hasError) {
                if (this.state.isLoaded) {
                    return (
                        <div className="h-100">
                            <div className="d-flex justify-content-between align-items-center mb-5">
                                <div>
                                    <h2 className="font-weight-light mb-2">Server Statistics</h2>
                                    <div className="badge badge-success font-weight-bold">RUNNING</div>
                                </div>
                                <button className="btn btn-lg btn-default" onClick={this.refreshData()}>
                                    <i className="ion ion-md-refresh text-primary"></i> Refresh
                                </button>
                            </div>
                            <div className="row">
                                {this.state.monitors.map(function (monitor, index) {
                                    let time = moment.unix(monitor.create_datetime).format("dddd, MMMM Do YYYY");
                                    let downTime = 100 - Math.floor(monitor.all_time_uptime_ratio);
                                    let iconStyle = 'ion ion-ios-trending-up';
                                    let textColor = 'text-success';
                                    if (monitor.status !== 2) {
                                        backgroundColor = 'bg-danger';
                                        iconStyle = 'ion ion-ios-trending-down';
                                    }
                                    return <div className="col-sm-6 col-md-4 col-lg-6 col-xl-4" key={index}>
                                        <a href={'/servers/' + monitor.id}>
                                            <div
                                                className={"server-item border-light ui-bordered p-3 mt-2 bg-light shadow-sm"}>
                                                <div className="media align-items-center">
                                                    <div className="media-body small mr-3">
                                                        <div
                                                            className={"font-weight-semibold"}>{`${ monitor.friendly_name }`}</div>
                                                        <div className={"text-xs text-muted"}>{`${ monitor.url}`}</div>
                                                        <div className={"text-xs text-muted mb-3"}>{`${ time }`}</div>
                                                        <div className={"mb-1"}>Up time: <span
                                                            className={"d-inline text-success"}>%{`${
                                                            Math.floor(monitor.all_time_uptime_ratio) }`}
                                                            <i className={"pe-7s-angle-up text-success font-weight-bold"}></i></span>
                                                        </div>
                                                        <div className={"mb-1"}>Down time: <span
                                                            className={"d-inline text-danger"}>%{`${ downTime }`}
                                                            <i className={"pe-7s-angle-down text-danger font-weight-bold"}></i></span>
                                                        </div>
                                                    </div>
                                                    <div className="d-flex align-items-center position-relative"
                                                         style={{height: '60px', width: '60px'}}>
                                                        <div className="w-100 position-absolute"
                                                             style={{height: '60px', top: '0'}}>

                                                        </div>
                                                        <div
                                                            className={"w-100 text-center font-weight-bold text-center " + textColor}>
                                                            <div className={"p-3 d-block bg-success"}
                                                                 style={{
                                                                     borderRadius: '100%',
                                                                     width: '40px',
                                                                     height: '40px'
                                                                 }}>
                                                                <i className={"text-white d-block " + iconStyle}
                                                                   style={{fontSize: '24px', margin: '-8px'}}></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                })}
                                <div className="col-sm-6 col-md-4 col-lg-6 col-xl-4">
                                    <div className={"server-item border-light ui-bordered p-3 mt-2 bg-light shadow-sm"}
                                         style={{border: '3px dashed #cdcdcd'}}>
                                        <div className="media align-items-center">
                                            <div className="media-body small mr-3">
                                                <div className="d-flex justify-content-center">
                                                    <div className={"text-center m-3"} style={{
                                                        width: '45px',
                                                        height: '45px',
                                                        borderRadius: '100%',
                                                        border: '1px dashed #cdcdcd'
                                                    }}>
                                                        <i className="ion ion-md-add" style={{
                                                            fontSize: '18px',
                                                            color: '#888',
                                                            marginTop: '13px'
                                                        }}></i>
                                                    </div>
                                                </div>
                                                <div className="d-flex justify-content-center">
                                                    <div className={"text-center"}>
                                                        <p className={"m-1"}>Add Server</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    );
                } else {
                    return (
                        <StandardLoadingComponent/>
                    )
                }
            } else {
                return (
                    <ErrorComponent errorDetails={this.state.errors}/>
                );
            }
    }
}

if (document.getElementById('server-wrapper')) {
    ReactDOM.render(<ServerMonitors />, document.getElementById('server-wrapper'));
}