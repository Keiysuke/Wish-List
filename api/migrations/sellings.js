'use strict';
module.exports = {
  up: async (queryInterface, Sequelize) => {
    return Promise.all([
      await queryInterface.createTable('sellings', {
        id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
          primaryKey: true,
          autoIncrement: true,
        },
        product_id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
        },
        product_state_id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
        },
        purchase_id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
        },
        website_id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
        },
        sell_state_id: {
          type: Sequelize.INTEGER(1).UNSIGNED,
          allowNull: false,
        },
        price: {
          type: Sequelize.DECIMAL(10,2),
          allowNull: false,
        },
        confirmed_price: {
          type: Sequelize.DECIMAL(10,2),
          allowNull: true,
        },
        shipping_fees: {
          type: Sequelize.DECIMAL(10,2),
          allowNull: true,
        },
        shipping_fees_payed: {
          type: Sequelize.DECIMAL(10,2),
          allowNull: true,
        },
        url: {
          type: Sequelize.TEXT('long'),
          allowNull: true,
        },
        nb_views: {
          type: Sequelize.INTEGER(5),
          allowNull: true,
        },
        date_sold: {
          type: Sequelize.DATEONLY,
          allowNull: true,
        },
        date_begin: {
          type: Sequelize.DATEONLY,
          allowNull: true,
        },
        date_send: {
          type: Sequelize.DATEONLY,
          allowNull: true,
        },
        box: {
          type: Sequelize.TINYINT(1),
          allowNull: false,
        },
        createdAt: {
          type: Sequelize.DATE,
          allowNull: false,
        },
        updatedAt: {
          type: Sequelize.DATE,
          allowNull: false,
        },
      }),
      await queryInterface.addIndex(
        'sellings',
        ['product_id'],
        {
          name: 'fk_selling_product1_idx',
        }
      ),
      await queryInterface.addIndex(
        'sellings',
        ['product_state_id'],
        {
          name: 'fk_selling_product_state1_idx',
        }
      ),
      await queryInterface.addIndex(
        'sellings',
        ['website_id'],
        {
          name: 'fk_selling_website1_idx',
        }
      ),
      await queryInterface.addIndex(
        'sellings',
        ['sell_state_id'],
        {
          name: 'fk_selling_sell_state1_idx',
        }
      ),
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return Promise.all([
      queryInterface.dropTable('sellings')
    ]);
  }
};
