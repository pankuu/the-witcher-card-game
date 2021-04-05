import React, {Component} from "react";
import {createCards, deleteCards, getCards} from "./api/api_cards";
import Cards from './Cards'
import CardForm from './CardForm'


class App extends Component {

    _isMounted = false;

    state = {
        cards: [],
        isLoaded: false,
        links: []
    }

    componentDidMount() {
        this._isMounted = true;
        getCards().then((data) => {
            this.setState({
                cards: data.data,
                isLoaded: true,
                links: data.links
            })
        });
    }

    componentWillUnmount() {
        this.setState = (state, callback) => {
            return;
        };
    }

    // handleDeleteCard = (id) => {
    //     deleteCards(id)
    //         .then(() => {
    //
    //         });
    // }

    // handleSubmit = (data) => {
    //     console.log(data)
    //     createCards(data)
    //         .then(cards => {
    //             console.log(cards)
    //         })
    // }


    render() {
        return (
            <div className="ui container" style={{marginTop: "10px"}}>
                <p>The Witcher Cards Game</p>
                {/*<CardForm />*/}
                <Cards {...this.state} />
            </div>
        );
    }
}

export default App;