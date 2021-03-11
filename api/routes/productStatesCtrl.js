//Imports
const { Op } = require('sequelize');
const productStateModel = require('../models').product_states_model;
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
                productStateModel.findOne({
                    'attributes': ['label'],
                    'where': { 'label': label }
                })
                    .then((productStateFound) => { done(productStateFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'unable to verify product state', err); })
            },
            //On ajoute le nouvel état
        ], function (productStateFound) {
            if (productStateFound)
                return Flash.msg(res, 409, 'product state already exist');

            productStateModel.create({
                'label': label.toUpperCase()[0] + label.slice(1).toLowerCase(),
            })
                .then(function (newProductState) {
                    return Flash.msg(res, 201, { 'idProductState': newProductState.id })
                })
                .catch((err) => { return Flash.msg(res, 404, 'error on adding product state', err); })
        })
    },
    update: function (req, res) {
        //Params
        const id = req.body.id;
        const label = req.body.label;

        if (label == null)
            return Flash.msg(res, 400, 'parameter label is necessary');
        
        asyncLib.waterfall([
            //On vérifie que l'id correspond à un état de produit
            function (done) {
                productStateModel.findOne({
                    'attributes': ['id', 'label'],
                    'where': { 'id': id }
                })
                    .then((productStateFound) => { done(productStateFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'product state does not exist', err); })
            }

            //On modifie les infos de l'état
        ], function (productStateFound) {
            if (!productStateFound)
                return Flash.msg(res, 404, 'product state not found');

            productStateFound.update({
                'label': (label ? label : productStateFound.label),
            })
                .then(function () {
                    return Flash.msg(res, 201, productStateFound);
                })
                .catch((err) => { return Flash.msg(res, 500, 'error on updating product state', err); })
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
        
        productStateModel.findAll({
            'limit': (!isNaN(limit)) ? limit : null,
            'offset': (!isNaN(offset)) ? offset : null,
            'order': [(order != null) ? order.split(':') : ['label', 'ASC']],
            'where': whereCondition
        })
            .then(function (productStatesFound) {
                return Flash.msg(res, 201, {
                    'count': productStatesFound.length,
                    'results':
                        productStatesFound.map(r => {
                            return {
                                'id': r.id,
                                'label': r.label,
                                'url': '/api/categories/states/products/' + r.id,
                            }
                        })
                });
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on getting all products states', err); })
    },
    findOne: function (req, res) {
        var id = req.params.id;

        //On vérifie qu'un état de produit avec cet identifiant existe
        productStateModel.findOne({
            'attributes': ['id', 'label'],
            'where': { 'id': id },
        })
            .then(function (productStateFound) {
                return Flash.msg(res, 201, {
                    'id': productStateFound.id,
                    'label': productStateFound.label,
                })
            })
            .catch((err) => { return Flash.msg(res, 404, 'product state does not exist', err); })
    }
}