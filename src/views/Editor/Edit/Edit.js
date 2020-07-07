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

class Edit extends Component {
    static propTypes = {
        cookies: instanceOf(Cookies).isRequired
    };
    constructor(props) {
        super(props);
        this.loading    = this.loading.bind(this);
        this.apiSubmit  = this.apiSubmit.bind(this);
        const {cookies} = props;
        this.state = {
            token: cookies.get('token') || null,
            page: [],
            isLoaded: false,
        };
    }

    async componentDidMount() {

        const { location }   = this.props;
        const params        = new URLSearchParams(location.search);
        const title         = params.get("title");
        const id            = params.get("id");
        const contentFetch  = `https://ockb.rongeasse.com/api/v1/get?id=${id}`;

        fetch(contentFetch)
            .then((resContent) => {
                return resContent.json();
            })
            .then((contentJson) => {

                this.setState({
                    page: contentJson[0],
                    isLoaded: true,
                })

                if (Object.keys(this.state.page).length === 0) {
                    console.log('Erreur du chargement du contenu')
                }
            })
            .catch((e) => {
                this.setState({
                    hasError: e
                })
            });

    }

    loading() {
        return <div className="animated fadeIn pt-3 text-center">
            Loading...
        </div>;
    }

    apiSubmit(data) {

        const jsonData  = JSON.stringify(data);
        const token     = this.state.token;
        const urlPost   = 'https://ockb.rongeasse.com/api/v1/put';
        const headers   = new Headers();
        headers.append('Content-Type', 'application/json');
        headers.append('Authorization', token)

        const init = {
            method: 'PUT',
            headers,
            mode: 'cors',
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

        if (this.state.hasError) {
            return (
                <div>Erreur!</div>
            )
        }

        if (!this.state.isLoaded) {

            return (
                <div className="isLoading d-flex justify-content-center">
                    <div className="spinner-border" role="status">
                        <span className="sr-only">Loading...</span>
                    </div>
                </div>
            )

        } else {

            const {page} = this.state;

            return (

                <div className="animated fadeIn">
                    <Row>
                        <Col xs="12" sm="18">
                            <Card>
                                <CardHeader>
                                    <strong>Edition du billet</strong>
                                </CardHeader>
                                <CardBody>
                                    <EditorForm submit={this.apiSubmit} page={page} />
                                </CardBody>
                            </Card>
                        </Col>
                    </Row>
                </div>
            );
        }
    }
}

export default withCookies(Edit);
