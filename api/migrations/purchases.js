'use strict';
module.exports = {
  up: async (queryInterface, Sequelize) => {
    return Promise.all([
      await queryInterface.createTable('purchases', {
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
        website_id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
        },
        cost: {
          type: Sequelize.DECIMAL(10,2),
          allowNull: false,
        },
        date: {
          type: Sequelize.DATEONLY,
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
        'purchases',
        ['product_state_id'],
        {
          name: 'fk_purchase_product_state1_idx',
        }
      ),
      await queryInterface.addIndex(
        'purchases',
        ['product_id'],
        {
          name: 'fk_purchase_product1_idx',
        }
      ),
      await queryInterface.addIndex(
        'purchases',
        ['website_id'],
        {
          name: 'fk_purchase_website1_idx',
        }
      ),
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return Promise.all([
      queryInterface.dropTable('purchases')
    ]);
  }
};
