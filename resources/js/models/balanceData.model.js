import {Currencies, Currency} from "./currencies";

class BalanceData {
    constructor() {
        /** @type {Array<Asset>} */
        this.assets = [];
        /** @type {Array<Liability>} */
        this.liabilities = [];
        /** @type {Array<Income>} */
        this.incomes = [];
        /** @type {Array<Expense>} */
        this.expenses = [];
    }

    static fromArray(rawData) {
        let balance = new BalanceData();

        if (typeof rawData['assets'] !== 'undefined') {
            balance.assets = _.map(rawData['assets'], asset => Asset.fromArray(asset))
        }

        if (typeof rawData['liabilities'] !== 'undefined') {
            balance.liabilities = _.map(rawData['liabilities'], liability => Liability.fromArray(liability))
        }

        if (typeof rawData['incomes'] !== 'undefined') {
            balance.incomes = _.map(rawData['incomes'], income => Income.fromArray(income))
        }

        if (typeof rawData['expenses'] !== 'undefined') {
            balance.expenses = _.map(rawData['expenses'], expense => Expense.fromArray(expense))
        }

        return balance;
    }

    /**
     * @param inCurrency {Currency}
     * @returns {string}
     */
    getTotalBalance(inCurrency) {
        return (parseFloat(this.getTotalAssets(inCurrency)) - parseFloat(this.getTotalLiabilities(inCurrency)))
            .toFixed(inCurrency.precision);
    }

    /**
     * @param inCurrency {Currency}
     * @returns {string}
     */
    getTotalAssets(inCurrency) {
        return this.assets.reduce(
            (sum, asset) => sum + (asset.amount / inCurrency.getRate(asset.currency)),
            0.00
        ).toFixed(inCurrency.precision);
    }

    /**
     * @param inCurrency {Currency}
     * @returns {string}
     */
    getTotalLiabilities(inCurrency) {
        return this.liabilities.reduce(
            (sum, liability) => sum + (liability.amount / inCurrency.getRate(liability.currency)),
            0.00
        ).toFixed(inCurrency.precision);
    }

    /**
     * @param inCurrency {Currency}
     * @returns {string}
     */
    getTotalBudget(inCurrency) {
        return (parseFloat(this.getTotalIncomes(inCurrency)) - parseFloat(this.getTotalExpenses(inCurrency)))
            .toFixed(inCurrency.precision);
    }

    /**
     * @param inCurrency {Currency}
     * @returns {string}
     */
    getTotalIncomes(inCurrency) {
        return this.incomes.reduce(
            (sum, income) => sum + (income.amount / inCurrency.getRate(income.currency)),
            0.00
        ).toFixed(inCurrency.precision);
    }

    /**
     * @param inCurrency {Currency}
     * @returns {string}
     */
    getTotalExpenses(inCurrency) {
        return this.expenses.reduce(
            (sum, expense) => sum + (expense.amount / inCurrency.getRate(expense.currency)),
            0.00
        ).toFixed(inCurrency.precision);
    }
}

class MoneyValue {
    constructor(currency = Currencies.DEFAULT_CURRENCY) {
        /** @type {Number} */
        this.id = null;
        /** @type {Number} */
        this.amount = 0;
        /** @type {String} */
        this.currency = currency;
    }

    static fromArray(rawData) {
        return _.assign(new this(), rawData);
    }
}

class Asset extends MoneyValue {
    saveNewAsset(callback, clearData = false) {
        axios.post(
            '/balance/save-asset',
            {amount: this.amount, currency: this.currency}
        ).then((response) => {
            if (clearData) {
                this.amount = 0;
            }

            callback();
        }).catch((error) => {
            console.log(error)
        });
    }

    editAsset() {
        axios.post(
            '/balance/edit-asset',
            {id: this.id, amount: this.amount}
        ).then((response) => {
            // do nothing
        }).catch((error) => {
            console.log(error)
        });
    }

    deleteAsset(callback) {
        axios.post(
            '/balance/delete-asset',
            {id: this.id}
        ).then((response) => {
            callback();
        }).catch((error) => {
            console.log(error)
        });
    }
}

class Liability extends MoneyValue {
    saveNewLiability(callback, clearData = false) {
        axios.post(
            '/balance/save-liability',
            {amount: this.amount, currency: this.currency}
        ).then((response) => {
            if (clearData) {
                this.amount = 0;
            }

            callback();
        }).catch((error) => {
            console.log(error)
        });
    }

    editLiability() {
        axios.post(
            '/balance/edit-liability',
            {id: this.id, amount: this.amount}
        ).then((response) => {
            // do nothing
        }).catch((error) => {
            console.log(error)
        });
    }

    deleteLiability(callback) {
        axios.post(
            '/balance/delete-liability',
            {id: this.id}
        ).then((response) => {
            callback();
        }).catch((error) => {
            console.log(error)
        });
    }
}

class Income extends MoneyValue {
    saveNewIncome(callback, clearData = false) {
        axios.post(
            '/balance/save-income',
            {amount: this.amount, currency: this.currency}
        ).then((response) => {
            if (clearData) {
                this.amount = 0;
            }

            callback();
        }).catch((error) => {
            console.log(error)
        });
    }

    editIncome() {
        axios.post(
            '/balance/edit-income',
            {id: this.id, amount: this.amount}
        ).then((response) => {
            // do nothing
        }).catch((error) => {
            console.log(error)
        });
    }

    deleteIncome(callback) {
        axios.post(
            '/balance/delete-income',
            {id: this.id}
        ).then((response) => {
            callback();
        }).catch((error) => {
            console.log(error)
        });
    }
}

class Expense extends MoneyValue {
    saveNewExpense(callback, clearData = false) {
        axios.post(
            '/balance/save-expense',
            {amount: this.amount, currency: this.currency}
        ).then((response) => {
            if (clearData) {
                this.amount = 0;
            }

            callback();
        }).catch((error) => {
            console.log(error)
        });
    }

    editExpense() {
        axios.post(
            '/balance/edit-expense',
            {id: this.id, amount: this.amount}
        ).then((response) => {
            // do nothing
        }).catch((error) => {
            console.log(error)
        });
    }

    deleteExpense(callback) {
        axios.post(
            '/balance/delete-expense',
            {id: this.id}
        ).then((response) => {
            callback();
        }).catch((error) => {
            console.log(error)
        });
    }
}

export {BalanceData, Asset, Liability, Income, Expense};
