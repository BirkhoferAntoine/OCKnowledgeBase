import React, { Component } from 'react';
import { instanceOf } from 'prop-types';
import { withCookies, Cookies } from 'react-cookie';
import {
    Card,
    CardBody,
    CardHeader,
    Col,
    Row,
} from 'reactstrap';
import EditorForm from "../EditorForm";

class New extends Component {
    static propTypes = {
        cookies: instanceOf(Cookies).isRequired
    };
    constructor(props) {
        super(props);
        this.apiSubmit          = this.apiSubmit.bind(this);
        const { cookies }       = props;
        this.state = {
            token: cookies.get('token') || null,
        };
    }

    apiSubmit(data) {

        const jsonData      = JSON.stringify(data);
        const token         = this.state.token;
        const urlPost       = 'https://ockb.rongeasse.com/api/v1/post';
        const headers       = new Headers();
        headers.append('Authorization', token);
        headers.entries().map((header) => {
            return console.log('headers', header)
        })


        const init = {
            method: 'POST',
            headers: {
                "Authorization": token,
                "Content-Type": "application/json"
            },
            body: jsonData
        };

        fetch(urlPost, init)
            .then((response) => {
                alert('sent')
                return response.json(); // or .text() or .blob() ...
            })
            .then((text) => {
                alert(text)
            })
            .catch((e) => {
                alert(`Erreur lors de la transmission  , ${e}`)
            });
    }

    render() {
        return (
            <div className="animated fadeIn">
                <Row>
                    <Col xs="12" sm="18">
                        <Card>
                            <CardHeader>
                                <strong>Nouveau billet</strong>
                            </CardHeader>
                            <CardBody>
                                <EditorForm submit={this.apiSubmit} />
                            </CardBody>
                        </Card>
                    </Col>
                </Row>
            </div>
        );
    }
}

export default withCookies(New);
