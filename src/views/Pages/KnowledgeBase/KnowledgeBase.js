import React, { Component } from 'react';

import {
    CardGroup, 
    Col, 
    Container,
    Row,
} from 'reactstrap';
import { CategoryCard } from './index.js';
import { HomeTabs } from './index';

class KnowledgeBase extends Component {
    constructor(props) {
        super(props);
        this.categoryCardsBuilder   = this.categoryCardsBuilder.bind(this);
        this.contentSorter          = this.contentSorter.bind(this);
        this.loading                = this.loading.bind(this);
        this.state = {
            hasError:           false,
            content:            [],
            categories:         [],
            knowledgeCards:     [],
            isLoaded:           false,
        }
    }

    async componentDidMount() {

        const contentFetch      = await fetch('https://ockb.rongeasse.com/api/v1/get?content=true');
        const categoriesFetch   = await fetch('https://ockb.rongeasse.com/api/v1/get?categories=true');

        Promise.all([ contentFetch, categoriesFetch ])
            .then(async ([ resContent, resCategories ]) =>
                Promise.all(
                    [ await resContent.json(),
                            await resCategories.json()])
            )
            .then(async ([ contentJson, categoriesJson ]) => {

                const sortedContent    = await this.contentSorter(contentJson, categoriesJson)
                const knowledgeCards   = await this.categoryCardsBuilder(categoriesJson, sortedContent)

                await this.setState({
                    content:        contentJson,
                    categories:     categoriesJson,
                    knowledgeCards: knowledgeCards,
                    isLoaded:       true,
                })

                if (Object.keys(this.state.content).length === 0) {
                    console.log('Erreur du chargement du contenu')
                }
                if (Object.keys(this.state.categories).length === 0) {
                    console.log('Erreur du chargement des categories')
                }
        })
            .catch((e) => {
                this.setState({
                    hasError: e
                })
            });

    }
    
    async categoryCardsBuilder(categories, content) {
        const categoryCards = []

        for (let [key, value] of Object.entries(content)) {

            categoryCards.push(
                <CategoryCard data={value}
                              key={key} />)
        }

        return categoryCards;
    }

    async contentSorter(content, categories) {
        const contentObj  = {}

        for (const category of categories)
        {
            const categoryName          = await category['category_name']
            contentObj[categoryName]    = await content.filter(
                page =>
                    page['category'] === categoryName
            )
            contentObj[categoryName]['details'] = await category
        }
        return contentObj
    }

    loading () {
        return <div className="animated fadeIn pt-3 text-center">
            Loading...
        </div>;
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
          
      } 
      
      else {
          const { knowledgeCards } = this.state
          
          return (
              <div className="app flex-row align-items-center">
                  <Container className="m-auto">
                      <div className="animated fadeIn">
                      <HomeTabs />
                      <Row className="justify-content-center mt-2">
                          <Col className="firstCol" md="12">
                              <CardGroup className="animated fadeIn">
                                  <React.Suspense fallback={this.loading()}>
                                      {
                                        knowledgeCards
                                      }
                                  </React.Suspense>
                              </CardGroup>
                          </Col>
                      </Row>
                      </div>
                  </Container>
              </div>
          );
      }
  }
}

export default KnowledgeBase;
