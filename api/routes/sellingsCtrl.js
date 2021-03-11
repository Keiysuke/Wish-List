//Imports
const { Op } = require('sequelize');
const SellingModel = require('../models').sellings_model;
const asyncLib = require('async');
const Flash = require('../middlewares/Flash');

//Routes
module.exports = {
    create: function (req, res) {
        const product_id = req.body.product_id;
        const product_state_id = req.body.product_state_id;
        const purchase_id = req.body.purchase_id;
        const website_id = req.body.website_id;
        const sell_state_id = req.body.sell_state_id;
        const price = req.body.price;
        const confirmed_price = req.body.confirmed_price;
        const shipping_fees = req.body.shipping_fees;
        const shipping_fees_payed = req.body.shipping_fees_payed;
        const url = req.body.url;
        const nb_views = req.body.nb_views;
        const date_begin = req.body.date_begin;
        const date_sold = req.body.date_sold;
        const date_send = req.body.date_send;
        let box = req.body.box;
        
        if (product_id == null || product_state_id == null || purchase_id == null || website_id == null || sell_state_id == null || price == null || box == null)
            return Flash.msg(res, 400, 'parameter product_id, product_state_id, purchase_id, website_id, sell_state_id, price and box are necessary');

        if (!['true', 'false'].includes(box))
            return Flash.msg(res, 400, 'parameter box must be equals to true or false');

        box = (box == 'false') ? 0 : 1;

        SellingModel.create({
            'product_id' : product_id,
            'product_state_id' : product_state_id,
            'purchase_id' : purchase_id,
            'website_id' : website_id,
            'sell_state_id' : sell_state_id,
            'price' : price,
            'confirmed_price' : confirmed_price,
            'shipping_fees' : shipping_fees,
            'shipping_fees_payed' : shipping_fees_payed,
            'url' : url,
            'nb_views' : nb_views,
            'date_begin' : date_begin,
            'date_sold' : date_sold,
            'date_send' : date_send,
            'box' : box,
        })
        .then(function (newSelling) {
            return Flash.msg(res, 201, { 'idSelling': newSelling.id })
        })
        .catch((err) => { return Flash.msg(res, 404, 'error on adding selling', err); })
    },
    update: function (req, res) {
        //Params
        const id = req.body.id;
        const product_state_id = req.body.product_state_id;
        const purchase_id = req.body.purchase_id;
        const website_id = req.body.website_id;
        const sell_state_id = req.body.sell_state_id;
        const price = req.body.price;
        const confirmed_price = req.body.confirmed_price;
        const shipping_fees = req.body.shipping_fees;
        const shipping_fees_payed = req.body.shipping_fees_payed;
        const url = req.body.url;
        const nb_views = req.body.nb_views;
        const date_begin = req.body.date_begin;
        const date_sold = req.body.date_sold;
        const date_send = req.body.date_send;
        let box = req.body.box;
        
        if (id == null || product_state_id == null || purchase_id == null || website_id == null || sell_state_id == null || price == null || box == null)
            return Flash.msg(res, 400, 'parameter id, product_state_id, purchase_id, website_id, sell_state_id, price and box are necessary');

        if (!['true', 'false'].includes(box))
            return Flash.msg(res, 400, 'parameter box must be equals to true or false');

        box = (box == 'false') ? 0 : 1;
        
        asyncLib.waterfall([
            //On vérifie que l'id correspond à un achat
            function (done) {
                SellingModel.findOne({
                    'attributes': ['id','product_id','product_state_id','purchase_id','website_id','sell_state_id','price','confirmed_price','shipping_fees','shipping_fees_payed','url','nb_views','date_begin','date_sold','date_send','box'],
                    'where': { 'id': id }
                })
                .then((sellingFound) => { done(sellingFound); })
                .catch((err) => { return Flash.msg(res, 404, 'website does not exist', err); })
            }

            //On modifie les infos de l'achat
        ], function (sellingFound) {
            if (!sellingFound)
                return Flash.msg(res, 404, 'website not found');

            sellingFound.update({
                'product_state_id' : (product_state_id ? product_state_id : sellingFound.product_state_id),
                'purchase_id' : (purchase_id ? purchase_id : sellingFound.purchase_id),
                'website_id' : (website_id ? website_id : sellingFound.website_id),
                'sell_state_id' : (sell_state_id ? sell_state_id : sellingFound.sell_state_id),
                'price' : (price ? price : sellingFound.price),
                'confirmed_price' : (confirmed_price ? confirmed_price : sellingFound.confirmed_price),
                'shipping_fees' : (shipping_fees ? shipping_fees : sellingFound.shipping_fees),
                'shipping_fees_payed' : (shipping_fees_payed ? shipping_fees_payed : sellingFound.shipping_fees_payed),
                'url' : (url ? url : sellingFound.url),
                'nb_views' : (nb_views ? nb_views : sellingFound.nb_views),
                'date_begin' : (date_begin ? date_begin : sellingFound.date_begin),
                'date_sold' : (date_sold ? date_sold : sellingFound.date_sold),
                'date_send' : (date_send ? date_send : sellingFound.date_send),
                'box' : (box ? box : sellingFound.box),
            })
            .then(function () {
                return Flash.msg(res, 201, sellingFound);
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
        
        SellingModel.findAll({
            'limit': (!isNaN(limit)) ? limit : null,
            'offset': (!isNaN(offset)) ? offset : null,
            'order': [(order != null) ? order.split(':') : ['id', 'ASC']],
            'where': whereCondition
        })
            .then(function (sellingsFound) {
                return Flash.msg(res, 201, {
                    'count': sellingsFound.length,
                    'results':
                        sellingsFound.map(r => {
                            return {
                                'id': r.id,
                                'product_id': r.product_id,
                                'product_state_id': r.product_state_id,
                                'purchase_id': r.purchase_id,
                                'website_id': r.website_id,
                                'sell_state_id': r.sell_state_id,
                                'price': r.price,
                                'confirmed_price': r.confirmed_price,
                                'shipping_fees': r.shipping_fees,
                                'shipping_fees_payed': r.shipping_fees_payed,
                                'url': r.url,
                                'nb_views': r.nb_views,
                                'date_begin': r.date_begin,
                                'date_sold': r.date_sold,
                                'date_send': r.date_send,
                                'box': (r.box ? 'with' : 'without'),
                                'url': '/api/selling/' + r.id,
                            }
                        })
                });
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on getting all selling', err); })
    },
    findOne: function (req, res) {
        var id = req.params.id;

        //On vérifie qu'une vente avec cet identifiant existe
        SellingModel.findOne({
            'attributes': ['id','product_id','product_state_id','purchase_id','website_id','sell_state_id','price','confirmed_price','shipping_fees','shipping_fees_payed','url','nb_views','date_begin','date_sold','date_send','box'],
            'where': { 'id': id },
        })
            .then(function (sellingFound) {
                return Flash.msg(res, 201, {
                    'id': sellingFound.id,
                    'product_id': sellingFound.product_id,
                    'product_state_id': sellingFound.product_state_id,
                    'purchase_id': sellingFound.purchase_id,
                    'website_id': sellingFound.website_id,
                    'sell_state_id': sellingFound.sell_state_id,
                    'price': sellingFound.price,
                    'confirmed_price': sellingFound.confirmed_price,
                    'shipping_fees': sellingFound.shipping_fees,
                    'shipping_fees_payed': sellingFound.shipping_fees_payed,
                    'url': sellingFound.url,
                    'nb_views': sellingFound.nb_views,
                    'date_begin': sellingFound.date_begin,
                    'date_sold': sellingFound.date_sold,
                    'date_send': sellingFound.date_send,
                    'box': (sellingFound.box ? 'with' : 'without'),
                })
            })
            .catch((err) => { return Flash.msg(res, 404, 'selling does not exist', err); })
    }
}