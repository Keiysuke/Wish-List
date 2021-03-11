//Imports
const { Op } = require('sequelize');
const sellStateModel = require('../models').sell_states_model;
const asyncLib = require('async');
const Flash = require('../middlewares/Flash');

//Routes
module.exports = {
    create: function (req, res) {
        const label = req.body.label;

        if (label == null)
            return Flash.msg(res, 400, 'parameter label is necessary');

        asyncLib.waterfall([
            //On vérifie que l'état n'existe pas déjà
            function (done) {
                sellStateModel.findOne({
                    'attributes': ['label'],
                    'where': { 'label': label }
                })
                    .then((sellStateFound) => { done(sellStateFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'unable to verify sell state', err); })
            },
            //On ajoute le nouvel état
        ], function (sellStateFound) {
            if (sellStateFound)
                return Flash.msg(res, 409, 'sell state already exist');

            sellStateModel.create({
                'label': label.toUpperCase()[0] + label.slice(1).toLowerCase(),
            })
                .then(function (newSellState) {
                    return Flash.msg(res, 201, { 'idSellState': newSellState.id })
                })
                .catch((err) => { return Flash.msg(res, 404, 'error on adding sell state', err); })
        })
    },
    update: function (req, res) {
        //Params
        const id = req.body.id;
        const label = req.body.label;

        if (label == null)
            return Flash.msg(res, 400, 'parameter label is necessary');
        
        asyncLib.waterfall([
            //On vérifie que l'id correspond à un état de vente
            function (done) {
                sellStateModel.findOne({
                    'attributes': ['id', 'label'],
                    'where': { 'id': id }
                })
                    .then((sellStateFound) => { done(sellStateFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'sell state does not exist', err); })
            }

            //On modifie les infos de l'état
        ], function (sellStateFound) {
            if (!sellStateFound)
                return Flash.msg(res, 404, 'sell state not found');

            sellStateFound.update({
                'label': (label ? label : sellStateFound.label),
            })
                .then(function () {
                    return Flash.msg(res, 201, sellStateFound);
                })
                .catch((err) => { return Flash.msg(res, 500, 'error on updating sell state', err); })
        })
    },
    findAll: function (req, res) {
        const limit = parseInt(req.body.limit);
        const offset = parseInt(req.body.offset);
        const where = req.body.where;
        const order = req.body.order;

        let whereCondition = {};

        if (where) {
            whereCondition = where.split(',').map(conds => {
                const cond = conds.split(':');
                if (cond[0] == 'label')
                    return { [cond[0]]: { [Op.like]: '%' + cond[1] + '%' } }
                else
                    return { [cond[0]]: cond[1] }
            })
        }
        
        sellStateModel.findAll({
            'limit': (!isNaN(limit)) ? limit : null,
            'offset': (!isNaN(offset)) ? offset : null,
            'order': [(order != null) ? order.split(':') : ['label', 'ASC']],
            'where': whereCondition
        })
            .then(function (sellStatesFound) {
                return Flash.msg(res, 201, {
                    'count': sellStatesFound.length,
                    'results':
                        sellStatesFound.map(r => {
                            return {
                                'id': r.id,
                                'label': r.label,
                                'url': '/api/categories/states/sell/' + r.id,
                            }
                        })
                });
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on getting all sell states', err); })
    },
    findOne: function (req, res) {
        var id = req.params.id;

        //On vérifie qu'un état de vente avec cet identifiant existe
        sellStateModel.findOne({
            'attributes': ['id', 'label'],
            'where': { 'id': id },
        })
            .then(function (sellStateFound) {
                return Flash.msg(res, 201, {
                    'id': sellStateFound.id,
                    'label': sellStateFound.label,
                })
            })
            .catch((err) => { return Flash.msg(res, 404, 'sell state does not exist', err); })
    }
}