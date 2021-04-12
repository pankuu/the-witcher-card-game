import React, {Component} from "react";
import {createCards, deleteCards, getCards} from "./api/api_cards";
import Cards from './Cards'
import CardForm from './CardForm'


class App extends Component {

    // _isMounted = false;

    constructor(props) {
        super(props);

        this.state = {
            cards: [],
            isLoaded: false,
            _isMounted: false,
            links: [],
            title: '',
            power: 0,
            value: '',
            message: '',
            isSavingNewCard: false
        }
        this.messageTimeoutHandle = 0;

        this.handleFormSubmit = this.handleFormSubmit.bind(this);
        this.handleDeleteCard = this.handleDeleteCard.bind(this);
    }

    componentDidMount() {
        this.state._isMounted = true;
        this.fetchCards();
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevState !== this.state) {
            this.fetchCards();
        }
    }

    componentWillUnmount() {
        clearTimeout(this.messageTimeoutHandle);
        this.setState({});
    }

    handleDeleteCard(title) {
        deleteCards(title)
            .then(res => {
                console.log(res);
                this.setState({message: res.status})
                this.setMessage(res.status)
            });
    }

    fetchCards() {
        getCards().then((data) => {
            this.setState({
                cards: data.data,
                isLoaded: true,
                links: data.links
            })
        });
    }

    handleFormSubmit(title, power) {
        const formData = new FormData();
        formData.append('title', title);
        formData.append('power', power);

        this.setState({
            isSavingNewCard: true
        });

        createCards(formData)
            .then(cards => {
                console.log(cards)
                this.setState({
                    isLoaded: true,
                    isSavingNewCard: false,
                    message: cards.status,
                })
                this.setMessage()
            })
    }


    setMessage() {
        clearTimeout(this.messageTimeoutHandle);
        this.messageTimeoutHandle = setTimeout(() => {
            this.setState({
                message: ''
            });
            this.messageTimeoutHandle = 0;
        }, 3000)
    }


    render() {
        return (
            <div className="col-md-7">
                <div className="ui container" style={{marginTop: "10px"}}>
                    <h3>The Witcher Cards Game</h3>
                    <CardForm
                        {...this.props}
                        onNewCardSubmit={this.handleFormSubmit}
                    />
                    <Cards
                        {...this.state}
                        {...this.props}
                        onDeleteCard={this.handleDeleteCard}
                    />
                </div>
            </div>
        );
    }
}

export default App;