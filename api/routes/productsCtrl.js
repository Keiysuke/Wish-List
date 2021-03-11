//Imports
const { Op } = require('sequelize');
const ProductModel = require('../models').products_model;
const asyncLib = require('async');
const Flash = require('../middlewares/Flash');

//Constants
const PRODUCT_LIMIT = 15;

//Routes
module.exports = {
    create: function (req, res) {
        const label = req.body.label;
        const description = req.body.description;
        const limited_edition = req.body.limited_edition;
        const real_cost = req.body.real_cost;

        if (label == null || description == null || limited_edition == null || real_cost == null)
            return Flash.msg(res, 400, 'parameters label, description, limited_edition and real_cost are necessary');

        asyncLib.waterfall([
            //On vérifie que le produit n'existe pas déjà
            function (done) {
                ProductModel.findOne({
                    'attributes': ['label'],
                    'where': { 'label': label }
                })
                    .then((productFound) => { done(productFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'unable to verify product', err); })
            },
            //On ajoute le nouveau produit
        ], function (productFound) {
            if (productFound)
                return Flash.msg(res, 409, 'product already exist');

            ProductModel.create({
                'label': label.toUpperCase()[0] + label.slice(1).toLowerCase(),
                'description': description,
                'limited_edition': limited_edition,
                'real_cost': real_cost,
            })
                .then(function (newProduct) {
                    return Flash.msg(res, 201, { 'idProduct': newProduct.id })
                })
                .catch((err) => { return Flash.msg(res, 404, 'error on adding product', err); })
        })
    },
    update: function (req, res) {
        //Params
        const id = req.body.id;
        const label = req.body.label;
        const description = req.body.description;
        const limited_edition = req.body.limited_edition;
        const real_cost = req.body.real_cost;

        if (label == null || description == null || limited_edition == null || real_cost == null)
            return Flash.msg(res, 400, 'parameters label, description, limited_edition and real_cost are necessary');
        
        asyncLib.waterfall([
            //On vérifie que l'id correspond à un produit
            function (done) {
                ProductModel.findOne({
                    'attributes': ['id', 'label'],
                    'where': { 'id': id }
                })
                    .then((productFound) => { done(productFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'product does not exist', err); })
            }

            //On modifie les infos du produit
        ], function (productFound) {
            if (!productFound)
                return Flash.msg(res, 404, 'product not found');

            productFound.update({
                'label': (label ? label : productFound.label),
                'description': (description ? description : productFound.description),
                'limited_edition': (limited_edition ? limited_edition : productFound.limited_edition),
                'real_cost': (real_cost ? real_cost : productFound.real_cost),
            })
                .then(function () {
                    return Flash.msg(res, 201, productFound);
                })
                .catch((err) => { return Flash.msg(res, 500, 'error on updating product', err); })
        })
    },
    findAll: function (req, res) {
        const limit = parseInt(req.body.limit);
        const offset = parseInt(req.body.offset);
        const where = req.body.where;
        const order = req.body.order;

        if (limit > PRODUCT_LIMIT) limit = PRODUCT_LIMIT;

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
        
        ProductModel.findAll({
            'limit': (!isNaN(limit)) ? limit : null,
            'offset': (!isNaN(offset)) ? offset : null,
            'order': [(order != null) ? order.split(':') : ['label', 'ASC']],
            'where': whereCondition
        })
            .then(function (productsFound) {
                return Flash.msg(res, 201, {
                    'count': productsFound.length,
                    'results':
                        productsFound.map(r => {
                            return {
                                'id': r.id,
                                'label': r.label,
                                'description': r.description,
                                'limited_edition': r.limited_edition,
                                'real_cost': r.real_cost,
                                'url': '/api/products/' + r.id,
                            }
                        })
                });
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on getting all products', err); })
    },
    findOne: function (req, res) {
        var id = req.params.id;

        //On vérifie qu'un produit avec cet identifiant existe
        ProductModel.findOne({
            'attributes': ['id', 'label', 'description', 'limited_edition', 'real_cost'],
            'where': { 'id': id },
        })
            .then(function (productFound) {
                return Flash.msg(res, 201, {
                    'id': productFound.id,
                    'label': productFound.label,
                    'description': productFound.description,
                    'limited_edition': productFound.limited_edition,
                    'real_cost': productFound.real_cost,
                })
            })
            .catch((err) => { return Flash.msg(res, 404, 'product does not exist', err); })
    }
}