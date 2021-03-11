'use strict';
module.exports = {
  up: async (queryInterface, Sequelize) => {
    return Promise.all([
      await queryInterface.createTable('list_product', {
        id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
          primaryKey: true,
          autoIncrement: true,
        },
        list_id: {
          type: Sequelize.INTEGER(11),
          allowNull: false,
        },
        product_id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
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
        'list_product',
        ['product_id'],
        {
          name: 'fk_list_has_product_product1_idx',
        }
      ),
      await queryInterface.addIndex(
        'list_product',
        ['list_id'],
        {
          name: 'fk_list_has_product_list1_idx',
        }
      ),
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return Promise.all([
      queryInterface.dropTable('list_product')
    ]);
  }
};
