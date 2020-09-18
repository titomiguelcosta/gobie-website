import React from 'react';
import ReactDOM from 'react-dom';

class Motto extends React.Component {
    render() {
        return (
            <p className="lead float-left text-muted">Source code analysis</p>
        );
    }
}

if (document.getElementById('motto')) {
    ReactDOM.render(<Motto />, document.getElementById('motto'));
}
