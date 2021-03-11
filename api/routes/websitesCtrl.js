//Imports
const { Op } = require('sequelize');
const WebsiteModel = require('../models').websites_model;
const asyncLib = require('async');
const Flash = require('../middlewares/Flash');

//Routes
module.exports = {
    create: function (req, res) {
        const label = req.body.label;
        const url = req.body.url;

        if (label == null)
            return Flash.msg(res, 400, 'parameter label is necessary');

        asyncLib.waterfall([
            //On vérifie que le site web n'existe pas déjà
            function (done) {
                WebsiteModel.findOne({
                    'attributes': ['label'],
                    'where': { 'label': label }
                })
                    .then((websiteFound) => { done(websiteFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'unable to verify website', err); })
            },
            //On ajoute le nouveau site web
        ], function (websiteFound) {
            if (websiteFound)
                return Flash.msg(res, 409, 'website already exist');

            WebsiteModel.create({
                'label': label.toUpperCase()[0] + label.slice(1).toLowerCase(),
                'url': url,
            })
                .then(function (newWebsite) {
                    return Flash.msg(res, 201, { 'idWebsite': newWebsite.id })
                })
                .catch((err) => { return Flash.msg(res, 404, 'error on adding website', err); })
        })
    },
    update: function (req, res) {
        //Params
        const id = req.body.id;
        const label = req.body.label;
        const url = req.body.url;

        if (label == null)
            return Flash.msg(res, 400, 'parameter label is necessary');
        
        asyncLib.waterfall([
            //On vérifie que l'id correspond à un site web
            function (done) {
                WebsiteModel.findOne({
                    'attributes': ['id', 'label'],
                    'where': { 'id': id }
                })
                    .then((websiteFound) => { done(websiteFound); })
                    .catch((err) => { return Flash.msg(res, 404, 'website does not exist', err); })
            }

            //On modifie les infos du site web
        ], function (websiteFound) {
            if (!websiteFound)
                return Flash.msg(res, 404, 'website not found');

            websiteFound.update({
                'label': (label ? label : websiteFound.label),
                'url': (url ? url : websiteFound.url),
            })
                .then(function () {
                    return Flash.msg(res, 201, websiteFound);
                })
                .catch((err) => { return Flash.msg(res, 500, 'error on updating website', err); })
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
        
        WebsiteModel.findAll({
            'limit': (!isNaN(limit)) ? limit : null,
            'offset': (!isNaN(offset)) ? offset : null,
            'order': [(order != null) ? order.split(':') : ['label', 'ASC']],
            'where': whereCondition
        })
            .then(function (websitesFound) {
                return Flash.msg(res, 201, {
                    'count': websitesFound.length,
                    'results':
                        websitesFound.map(r => {
                            return {
                                'id': r.id,
                                'label': r.label,
                                'net_url': r.url,
                                'url': '/api/websites/' + r.id,
                            }
                        })
                });
            })
            .catch((err) => { return Flash.msg(res, 500, 'error on getting all websites', err); })
    },
    findOne: function (req, res) {
        var id = req.params.id;

        //On vérifie qu'un site web avec cet identifiant existe
        WebsiteModel.findOne({
            'attributes': ['id', 'label', 'url'],
            'where': { 'id': id },
        })
            .then(function (websiteFound) {
                return Flash.msg(res, 201, {
                    'id': websiteFound.id,
                    'label': websiteFound.label,
                    'net_url': websiteFound.url,
                })
            })
            .catch((err) => { return Flash.msg(res, 404, 'website does not exist', err); })
    }
}