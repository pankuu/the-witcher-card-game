import React, {Component} from "react";
import {createCards, deleteCards, getCards} from "./api/api_cards";
import Card from './Card'
import CardForm from './CardForm'
import {addCardToDeck, createDecks, getDecks, listDeck} from "./api/api_decks";
import DeckForm from "./DeckForm";
import Deck from "./Deck";
import DeckCard from "./DeckCard";
import Game from "./Game";
import {play} from "./api/api_game";
import DisplayResults from "./DisplayResults";

class App extends Component {

    // _isMounted = false;

    constructor(props) {
        super(props);

        this.state = {
            cards: [],
            decks: [],
            isLoadedCards: false,
            isLoadedDecks: false,
            _isMounted: false,
            links: [],
            title: '',
            power: 0,
            value: '',
            message: '',
            isSavingNewCard: false,
            isSavingNewDeck: false,
            selectedDeck: '',
            selectedDeck1: '',
            selectedCard: '',
            game: []
        }
        this.messageTimeoutHandle = 0;

        this.handleFormCardSubmit = this.handleFormCardSubmit.bind(this);
        this.handleDeleteCard = this.handleDeleteCard.bind(this);
        this.handleFromDeckSubmit = this.handleFromDeckSubmit.bind(this);
        this.handleSelectDeck = this.handleSelectDeck.bind(this);
        this.handleSelectCard = this.handleSelectCard.bind(this);
        this.handleDeckCard = this.handleDeckCard.bind(this);
        this.handleShowDeckCards = this.handleShowDeckCards.bind(this);
        this.handlePlay = this.handlePlay.bind(this);
    }

    componentDidMount() {
        this.state._isMounted = true;
        this.fetchCards();
        this.fetchDecks();
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevState.isLoadedCards !== this.state.isLoadedCards) {
            this.fetchCards();
        }

        if (prevState.isLoadedDecks !== this.state.isLoadedDecks) {
            this.fetchDecks();
        }
    }

    componentWillUnmount() {
        clearTimeout(this.messageTimeoutHandle);
        this.setState({});
    }

    /// CARDS ///

    handleDeleteCard(title) {
        deleteCards(title)
            .then(res => {
                this.setState({message: res.status})
                this.setMessage(res.status)
            });
    }

    fetchCards() {
        getCards().then((data) => {
            this.setState({
                cards: data.data,
                isLoadedCards: true,
                links: data.links
            })
        });
    }

    handleFormCardSubmit(title, power) {
        const formData = new FormData();
        formData.append('title', title);
        formData.append('power', power);

        this.setState({
            isSavingNewCard: true,
            isLoaded: true,
        });

        createCards(formData)
            .then(cards => {
                this.setState({
                    isLoadedCards: false,
                    isSavingNewCard: false,
                    message: cards.status,
                })
                this.setMessage(cards.status)
            })
    }

    handleSelectCard(title) {
        this.setState({selectedCard: title})
    }

    /// DECKS ///

    fetchDecks() {
        getDecks().then((data) => {
            this.setState({
                decks: data.data,
                isLoadedDecks: true,
            })
        });
    }

    handleFromDeckSubmit(name) {
        const formData = new FormData();
        formData.append('name', name);

        this.setState({
            isSavingNewDeck: true,
            isLoadedDecks: true,
        });

        createDecks(formData)
            .then(decks => {
                this.setState({
                    isLoadedDecks: false,
                    isSavingNewDeck: false,
                    message: decks.status,
                })
                this.setMessage(decks.status)
            })
    }

    handleSelectDeck(name) {
        this.setState({selectedDeck: name})
    }

    handleDeckCard(deck, card) {
        const formData = new FormData();
        formData.append('cards', card);

        addCardToDeck(deck, formData)
            .then(res => {
                console.log(res)
            })
    }

    handleShowDeckCards(name) {
        listDeck(name)
            .then(res => {
                alert(`The power of this deck is: ${res.power}`)
            })
    }

    handlePlay(host, guest, numberOfCards) {
        const formData = new FormData();
        formData.append('host', host);
        formData.append('guest', guest);
        formData.append('numberOfCards', numberOfCards);

        play(formData)
            .then((res) => {
                this.setState({game: res})
            })
    }

    setMessage(message) {
        this.setState({
            message
        });

        clearTimeout(this.messageTimeoutHandle);
        this.messageTimeoutHandle = setTimeout(() => {
            this.setState({
                message: ''
            });
            this.messageTimeoutHandle = 0;
        }, 3000)
    }

    render() {
        const {message, game} = this.state;

        return (
            <div className="float-container">
                {message && (
                    <div className="alert alert-info text-center">
                        {message}
                    </div>
                )}
                <div className="center">
                    <h3>The Witcher Cards Game</h3>
                </div>
                <div className="float-child">
                    <CardForm{...this.props} onNewCardSubmit={this.handleFormCardSubmit}
                    />
                    <Card
                        {...this.state}
                        {...this.props}
                        onDeleteCard={this.handleDeleteCard}
                        onSelectCard={this.handleSelectCard}
                    />
                </div>
                <div className="float-child">
                    <DeckForm{...this.props} onNewDeckSubmit={this.handleFromDeckSubmit}/>
                    <Deck
                        {...this.state}
                        {...this.props}
                        onSelectDeck={this.handleSelectDeck}
                        onShowDeckCards={this.handleShowDeckCards}
                    />
                    <DeckCard{...this.state} handleSelectedDeckCard={this.handleDeckCard}/>
                </div>
                <div className="float-child">
                    <Game{...this.state} onPlaySubmit={this.handlePlay}/>
                    <DisplayResults game={game}/>
                </div>
            </div>
        );
    }
}

export default App;