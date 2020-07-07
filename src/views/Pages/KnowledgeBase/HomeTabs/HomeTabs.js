import React, { Component } from 'react';
import { Badge, Button, Card, CardBody, CardGroup, CardFooter, CardHeader, Col, Collapse, Fade, Nav, NavItem, NavLink, Row, TabContent, TabPane, Input, InputGroup, InputGroupText, Form, FormGroup } from 'reactstrap';
import classnames from 'classnames';

class HomeTabs extends Component {
    constructor(props) {
        super(props);

        this.toggle = this.toggle.bind(this);
        this.state = {
            color: 'primary',
            activeTab: new Array(4).fill('1'),
        };
    }

    lorem() {
        return 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit.'
    }

    toggle(tabPane, tab) {
        const newArray = this.state.activeTab.slice()
        newArray[tabPane] = tab
        this.setState({
            activeTab: newArray,
        });
    }

    tabPane() {
        return (
            <>
                <TabPane tabId="1">
                    <p>{`1. ${this.lorem()}`}</p>
                </TabPane>
                <TabPane tabId="2">
                    <p>{`2. ${this.lorem()}`}</p>
                </TabPane>
                <TabPane tabId="3">
                    <div className='divTab3'>
                        <Form>
                            <InputGroupText>
                            <input type={'text'} placeholder={'Rechercher'} />
                            </InputGroupText>
                        </Form>
                    </div>
                </TabPane>
            </>
        );
    }

    render() {
        return (
                <Row className="justify-content-center">
                        <Col xs="16" sm="8" md="6" className={'text-center m-auto cardDiv'}>
                            <Card className={`card-accent-${this.state.color} border-${this.state.color} mb-0`}>
                                <CardHeader className="d-flex no-wrap justify-content-center">
                                    <h3 className="categoryHeader">Bienvenue sur OCKnowledgeBase!</h3>
                                </CardHeader>
                                <CardBody>
                                    <Nav tabs className="no-wrap flex-row">
                                        <NavItem>
                                            <NavLink
                                                active={this.state.activeTab[0] === '1'}
                                                onClick={() => { this.toggle(0, '1'); }}
                                            >
                                                Introduction
                                            </NavLink>
                                        </NavItem>
                                        <NavItem>
                                            <NavLink
                                                active={this.state.activeTab[0] === '2'}
                                                onClick={() => { this.toggle(0, '2'); }}
                                            >
                                                News
                                            </NavLink>
                                        </NavItem>
                                        <NavItem>
                                            <NavLink
                                                active={this.state.activeTab[0] === '3'}
                                                onClick={() => { this.toggle(0, '3'); }}
                                            >
                                                Recherche
                                            </NavLink>
                                        </NavItem>
                                    </Nav>
                                    <TabContent activeTab={this.state.activeTab[0]}>
                                        {this.tabPane()}
                                    </TabContent>
                                </CardBody>
                            </Card>
                        </Col>
                </Row>
        );
    }
}

export default HomeTabs;
