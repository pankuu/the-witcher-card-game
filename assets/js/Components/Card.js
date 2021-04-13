import React from "react";

const Card = (props) => {

    const {
        cards,
        links,
        onDeleteCard,
        onSelectCard,
        isLoadedCards,
        isSavingNewCard,
        onNextPage,
        onPrevPage,
    } = props;

    const handleDeleteClick = function (event, cardTitle) {
        event.preventDefault();

        onDeleteCard(cardTitle);
    };

    const handleClick = function (event, cardTitle) {
        event.preventDefault();

        onSelectCard(cardTitle);
    };

    const handleClickNextPage = function(event) {
        event.preventDefault();

        onNextPage(links.next_page)
    }

    const handleClickPreviousPage = function(event) {
        event.preventDefault();

        onPrevPage(links.previous_page)
    }

    if (!isLoadedCards) {
        return (
            <div>
                <h3 className="text-center">Loading...</h3>
            </div>
        )
    }

    return (
        <div>
            <h4>Total cards ({links && links.total_items})</h4>
            <table className="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Power</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {cards.map((card) => (
                    <tr
                        key={card.id}
                    >
                        <td>{card.id}</td>
                        <td
                            style={{cursor:'pointer'}}
                            onClick={(event => handleClick(event, card.title))}
                        >
                            {card.title}
                        </td>
                        <td>{card.power}</td>
                        <td style={{cursor:'pointer'}}>
                            {!card.isBlocked &&
                            <a href="#" onClick={(event) => handleDeleteClick(event, card.title)}>
                                <i className="trash icon"/>
                            </a>
                            }
                            {card.isBlocked && <i className="lock icon" />}
                        </td>
                    </tr>
                ))}
                {isSavingNewCard && (
                    <tr>
                        <td
                            colSpan="4"
                            className="text-center"
                            style={{
                                opacity: .5
                            }}
                        >
                            Saving to the database ...
                        </td>
                    </tr>
                )}
                </tbody>
                <tfoot>
                <tr>
                    <td>&nbsp;</td>
                    <th>
                        <i
                            className="chevron left icon"
                            style={{cursor:'pointer'}}
                            onClick={handleClickPreviousPage}
                        />
                    </th>
                    <th>
                        <i
                            className="chevron right icon"
                            style={{cursor:'pointer'}}
                            onClick={handleClickNextPage}
                        />
                    </th>
                    <td>&nbsp;</td>
                </tr>
                </tfoot>
            </table>
        </div>
    );
}

export default Card;