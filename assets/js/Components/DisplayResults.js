import React from 'react'
import { v4 as uuid } from 'uuid';

const DisplayResults = (props) => {
    const {game} = props;
    return (
        <div>
            {game.message && <div>
                <h4>{game.message}</h4>
                <h5>Host cards: power: {game[0].Host.powerSum} bonus: {game[0].Host.bonus}</h5>
                {game[0].Host.cards.map((card) => (
                    <h6 key={card.title + uuid()}>{card.title}: ({card.power})</h6>
                ))}
                <h5>Guest cards: power: {game[1].Guest.powerSum} bonus: {game[1].Guest.bonus}</h5>
                {game[1].Guest.cards.map((card) => (
                    <h6 key={card.title + uuid()}>{card.title}: ({card.power})</h6>
                ))}
            </div>}
        </div>
    )
}

export default DisplayResults;