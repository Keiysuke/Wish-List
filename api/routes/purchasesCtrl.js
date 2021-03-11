//Imports
const { Op } = require('sequelize');
const PurchaseModel = require('../models').purchases_model;
const asyncLib = require('async');
const Flash = require('../middlewares/Flash');

//Routes
module.exports = {
    create: function (req, res) {
        const product_id = req.body.product_id;
        const product_state_id = req.body.product_state_id;
        const website_id = req.body.website_id;
        const cost = req.body.cost;
        const date = req.body.date;

        if (product_id == null || product_state_id == null || website_id == null || cost == null || date == null)
            return Flash.msg(res, 400, 'parameter product_id, product_state_id, website_id, cost and date are necessary');

        PurchaseModel.create({
            'product_id': product_id,
            'product_state_id': product_state_id,
            'website_id': website_id,
            'cost': cost,
            'date': date,
        })
        .then(function (newPurchase) {
            return Flash.msg(res, 201, { 'idPurchase': newPurchase.id })
        })
        .catch((err) => { return Flash.msg(res, 404, 'error on adding purchase', err); })
    },
    update: function (req, res) {
        //Params
        const id = req.body.id;
        const product_state_id = req.body.product_state_id;
        const website_id = req.body.website_id;
        const cost = req.body.cost;
        const date = req.body.date;

        if (id == null || product_state_id == null || website_id == null || cost == null || date == null)
            return Flash.msg(res, 400, 'parameter id, product_state_id, website_id, cost and date are necessary');
        
        asyncLib.waterfall([
            //On vérifie que l'id correspond à un achat
            function (done) {
                PurchaseModel.findOne({
                    'attributes': ['id', 'product_state_id', 'website_id', 'cost', 'date'],
                    'where': { 'id': id }
                })
                .then((purchaseFound) => { done(purchaseFound); })
                .catch((err) => { return Flash.msg(res, 404, 'website does not exist', err); })
            }

            //On modifie les infos de l'achat
        ], function (purchaseFound) {
            if (!purchaseFound)
                return Flash.msg(res, 404, 'website not found');

            purchaseFound.update({
                'product_state_id': (product_state_id ? product_state_id : purchaseFound.product_state_id),
                'website_id': (website_id ? website_id : purchaseFound.website_id),
                'cost': (cost ? cost : purchaseFound.cost),
                'date': (date ? date : purchaseFound.date),
            })
            .then(function () {
                return Flash.msg(res, 201, purchaseFound);
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on updating purchase', err); })
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
                if (cond[0] == 'id')
                    return { [cond[0]]: { [Op.like]: '%' + cond[1] + '%' } }
                else
                    return { [cond[0]]: cond[1] }
            })
        }
        
        PurchaseModel.findAll({
            'limit': (!isNaN(limit)) ? limit : null,
            'offset': (!isNaN(offset)) ? offset : null,
            'order': [(order != null) ? order.split(':') : ['id', 'ASC']],
            'where': whereCondition
        })
            .then(function (purchasesFound) {
                return Flash.msg(res, 201, {
                    'count': purchasesFound.length,
                    'results':
                        purchasesFound.map(r => {
                            return {
                                'id': r.id,
                                'product_id': r.product_id,
                                'product_state_id': r.product_state_id,
                                'website_id': r.website_id,
                                'cost': r.cost,
                                'date': r.date,
                                'url': '/api/purchases/' + r.id,
                            }
                        })
                });
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on getting all purchases', err); })
    },
    findOne: function (req, res) {
        var id = req.params.id;

        //On vérifie qu'un achat avec cet identifiant existe
        PurchaseModel.findOne({
            'attributes': ['id', 'product_id', 'product_state_id', 'website_id', 'cost', 'date'],
            'where': { 'id': id },
        })
            .then(function (purchaseFound) {
                return Flash.msg(res, 201, {
                    'id': purchaseFound.id,
                    'product_id': purchaseFound.product_id,
                    'product_state_id': purchaseFound.product_state_id,
                    'website_id': purchaseFound.website_id,
                    'cost': purchaseFound.cost,
                    'date': purchaseFound.date,
                })
            })
            .catch((err) => { return Flash.msg(res, 404, 'purchase does not exist', err); })
    }
}