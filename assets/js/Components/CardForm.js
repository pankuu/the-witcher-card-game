import React, {Component} from 'react'

class CardForm extends Component {
    constructor(props) {
        super(props);

        this.titleInput = React.createRef();
        this.powerInput = React.createRef();

        this.handleFormSubmit = this.handleFormSubmit.bind(this);
    }

    handleFormSubmit(event) {
        event.preventDefault();
        const {onNewCardSubmit} = this.props;

        const title = this.titleInput.current;
        const power = this.powerInput.current;

        onNewCardSubmit(
            title.value,
            power.value
        )

        title.value = '';
        power.value = '';
    }

    render() {
        return (
            <div className="container ui">
                <form className="form-inline" onSubmit={this.handleFormSubmit}>
                    <div className="form-group">
                        <input
                            placeholder="Title"
                            className="form-control"
                            ref={this.titleInput}
                            required="required"
                            type="text"
                            id="card_title"/>
                    </div>
                    <div className="form-group">
                        <input
                            placeholder="Power"
                            className="form-control"
                            ref={this.powerInput}
                            required="required"
                            type="number"
                            id="card_power"
                            min="0"
                        />
                    </div>
                    <div className="form-group">
                        <input type="submit" className="btn btn-primary" value="Add Card"/>
                    </div>
                </form>
            </div>
        )
    }
}

export default CardForm;