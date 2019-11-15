import React, { Component } from 'react';

export default class DomainAccountItem extends Component {
    constructor(props) {
        super(props);
        this.state = {
            domain: this.props.domain
        }
    }

    redirectTo(path) {
        window.location.href = path;
    }

    render() {
        let domain = this.props.domain;
        let renewDeadlineColor = '';
        let now = moment.tz(this.state.timezone);
        let renewDeadline = moment.tz(domain.details.renewDeadline, this.state.timezone);
        if (now > (renewDeadline.subtract(3, 'months'))) {
            renewDeadlineColor = 'text-info';
        }

        if (now > (renewDeadline.subtract(1, 'month'))) {
            renewDeadlineColor = 'text-danger';
        }
        const path = "/domains/" + domain.account.uid + '/' + domain.domain_info.domain;
        return (
            <div className="col-sm-6 col-md-4 col-lg-6 col-xl-4" >
                <div className="domain-account-item border-light ui-bordered bg-white p-3 mt-2"
                     onClick={() => this.redirectTo(path)}>
                    <div className="media align-items-center">
                        <div className="media-body small mr-3">
                            <div className="font-weight-semibold mb-3 text-primary"
                                 style={{fontSize: '1rem'}}>{`${domain.domain_info.domain}`}</div>
                            <div className="">Subdomains: {`${domain.dns.length - 1}`}</div>
                            <div>Purchased: {`${ moment.tz(domain.details.createdAt, this.state.timezone)
                                .format('LL') }`}</div>
                            <div className="mb-2">IP Address: {`${domain.dns[0].data}`}</div>
                            <div className={renewDeadlineColor}>Renewal Date: {`${renewDeadline.format('LL')}`}</div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }

}