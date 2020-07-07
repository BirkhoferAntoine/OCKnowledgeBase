import React, { Component } from 'react';
import { instanceOf } from 'prop-types';
import { withCookies, Cookies } from 'react-cookie';
import { Carousel, CarouselCaption, CarouselControl, CarouselIndicators, CarouselItem,
    Badge,
    Button,
    Card,
    CardBody,
    CardFooter,
    CardHeader,
    Col,
    Collapse,
    DropdownItem,
    DropdownMenu,
    DropdownToggle,
    Fade,
    Form,
    FormGroup,
    FormText,
    FormFeedback,
    Input,
    InputGroup,
    InputGroupAddon,
    InputGroupButtonDropdown,
    InputGroupText,
    Label,
    Row,
} from 'reactstrap';

class Gallery extends Component {
    static propTypes = {
        cookies: instanceOf(Cookies).isRequired
    };
    constructor(props) {
        super(props);
        //this.importAll      = this.importAll.bind(this);
        this.handleSubmit   = this.handleSubmit.bind(this);
        this.next           = this.next.bind(this);
        this.previous       = this.previous.bind(this);
        this.goToIndex      = this.goToIndex.bind(this);
        this.onExiting      = this.onExiting.bind(this);
        this.onExited       = this.onExited.bind(this);
        const { cookies } = props;
        const imagesFolder = '/../../../../resources/images';
/*        const importAll = (r) => {
            let images = {};
            r.keys().map((item, index) => { images[item.replace('./', '')] = r(item); });
            return images;
        }*/
        this.state = {
            pictures: [],
            activeIndex: 0,
            items: [],
            token: cookies.get('token') || null,
        };
    }

    componentDidMount() {
        //const {fsScandir} = this.props;
        const imagesFolder = '/../../../../resources/images';
        /*const entries = fsScandir.scandirSync(imagesFolder);
        const items = entries.map((image) => {
            console.log(image);
            return image;
        });*/
        /*const items = this.importAll(
            require.context(
                imagesFolder,
                true,
                /\.(png|jpe?g|svg|bmp)$/
            )
        );*/

        /*this.setState({
            items
        })*/
    }

    importAll(r) {
        let images = {};
        r.keys().map((item, index) => {
            images[item.replace('./', '')] = r(item);
        });
        return images;
    }

    async handleSubmit(event) {
        event.preventDefault();
        const pictures  = this.state.pictures[0];
        const data      = new FormData();
        console.log('pictures', pictures)
        data.append('images', pictures)
        await console.log(data);

        const token     = this.state.token
        const urlPost   = 'https://ockb.rongeasse.com/api/v1/upload';
        const headers   = new Headers();
        headers.append('Authorization', token);

        const init = {
            method: 'POST',
            headers,
            mode: 'cors',
            body: data
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

    onExiting() {
        this.animating = true;
    }

    onExited() {
        this.animating = false;
    }

    next() {
        if (this.animating) return;
        const nextIndex = this.state.activeIndex === this.state.items.length - 1 ? 0 : this.state.activeIndex + 1;
        this.setState({ activeIndex: nextIndex });
    }

    previous() {
        if (this.animating) return;
        const nextIndex = this.state.activeIndex === 0 ? this.state.items.length - 1 : this.state.activeIndex - 1;
        this.setState({ activeIndex: nextIndex });
    }

    goToIndex(newIndex) {
        if (this.animating) return;
        this.setState({ activeIndex: newIndex });
    }

    render() {
        const { activeIndex, items } = this.state;

        const slides = items.map((image) => {
            return (
                <CarouselItem onExiting={this.onExiting} onExited={this.onExited} key={image.src}>
                    <img className="d-block w-100" src={image.src} alt={image.altText} />
                </CarouselItem>
            );
        });

        const slides2 = items.map((item) => {
            return (
                <CarouselItem
                    onExiting={this.onExiting}
                    onExited={this.onExited}
                    key={item.src}
                >
                    <img className="d-block w-100" src={item.src} alt={item.altText} />
                    <CarouselCaption captionText={item.caption} captionHeader={item.caption} />
                </CarouselItem>
            );
        });

        return (
            <div className="animated fadeIn">
                <Row>
                    <Col xs="12" xl="6">
                        <Card>
                            <CardHeader>
                                <i className="fa fa-align-justify"></i><strong>Carousel</strong>
                                <div className="card-header-actions">
                                    <a href="https://reactstrap.github.io/components/carousel/" rel="noreferrer noopener" target="_blank" className="card-header-action">
                                        <small className="text-muted">docs</small>
                                    </a>
                                </div>
                            </CardHeader>
                            <CardBody>
                                <Carousel activeIndex={activeIndex} next={this.next} previous={this.previous} ride="carousel">
                                    {slides}
                                </Carousel>
                            </CardBody>
                        </Card>
                    </Col>
                    <Col xs="12" xl="6">
                        <Card>
                            <CardHeader>
                                <i className="fa fa-align-justify"></i><strong>Carousel</strong>
                            </CardHeader>
                            <CardBody>
                                <Carousel activeIndex={activeIndex} next={this.next} previous={this.previous}>
                                    <CarouselIndicators items={items} activeIndex={activeIndex} onClickHandler={this.goToIndex} />
                                    {slides2}
                                    <CarouselControl direction="prev" directionText="Previous" onClickHandler={this.previous} />
                                    <CarouselControl direction="next" directionText="Next" onClickHandler={this.next} />
                                </Carousel>
                            </CardBody>
                        </Card>
                    </Col>
                </Row>
            </div>
        );
    }
}
/*
render() {
        return (
            <div className="animated fadeIn">
                <Row>
                    <Col xs="12" sm="18">
                        <Card>
                            <CardHeader>
                                <strong>Héberger une nouvelle image</strong>
                            </CardHeader>
                            <CardBody>
                                <Form id="hostImageForm" onSubmit={this.handleSubmit} noValidate>
                                    <FormGroup className={"d-flex flex-column justify-content-evenly"}>
                                        <ImageUploader
                                            withIcon={true}
                                            buttonText='Choose images'
                                            onChange={this.onDrop}
                                            imgExtension={['.jpg', 'jpeg', '.gif', '.png', '.bmp']}
                                            maxFileSize={5242880}
                                        />
                                        <div className="form-actions d-flex justify-content-center m-2">
                                            <Button type="submit" color="primary">Envoyer</Button>
                                        </div>
                                    </FormGroup>
                                </Form>
                            </CardBody>
                        </Card>
                    </Col>
                </Row>
            </div>
        );
    }
}*/

export default withCookies(Gallery);
