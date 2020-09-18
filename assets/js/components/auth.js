import React from 'react';
import GobieApi from './../gobie-api';

export default class Auth extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            username: '',
            password: '',
            errors: false,
            loading: false,
        }
    }

    render() {
        const errors = this.state.errors
            ? <div className="alert alert-danger">Token invalid. Bad credentials.</div>
            : null;

        const button = this.state.loading
            ? <button className="btn btn-primary" type="button" disabled>
                <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Authenticating...
            </button>
            : <button onClick={(e) => this.handleSubmit(e)} type="submit" id="save" name="save" className="btn-primary btn">Authenticate</button>;

        return (
            <form method="post" id="authForm">
                {errors}

                <div className="form-group">
                    <label htmlFor="username" className="required">Username</label>
                    <input onKeyUp={(e) => this.handleUsernameUpdate(e)} type="text" id="username" name="username" required="required" className="form-control" placeholder="Username" autoComplete="username" />
                </div>
                <div className="form-group">
                    <label htmlFor="password" className="required">Password</label>
                    <input onKeyUp={(e) => this.handlePasswordUpdate(e)} type="password" id="password" name="password" required="required" className="form-control" placeholder="Password" autoComplete="password" />
                </div>

                <input type="hidden" name="_csrf_token" value={this.props.csrfToken} />
                <input type="hidden" name="_token" value={this.props.formToken} />

                <div className="form-group">
                    {button}
                </div>
            </form>
        );
    }

    handleUsernameUpdate(e) {
        this.setState({ username: e.target.value });
    }

    handlePasswordUpdate(e) {
        this.setState({ password: e.target.value });
    }

    handleSubmit(e) {
        e.preventDefault();
        this.setState({ loading: true });
        const gobie = new GobieApi();

        gobie
            .auth(this.state.username, this.state.password)
            .then(() => {
                if (gobie.errors) {
                    this.setState({ errors: true, loading: false });
                } else {
                    gobie.setUser(gobie.data);
                    document.getElementById('authForm').submit();
                }
            });
    }
}
