'use strict';
module.exports = {
  up: async (queryInterface, Sequelize) => {
    return Promise.all([
      await queryInterface.createTable('product_website', {
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
        website_id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
        },
        price: {
          type: Sequelize.DECIMAL(10,2),
          allowNull: false,
        },
        url: {
          type: Sequelize.TEXT('long'),
          allowNull: true,
        },
        available_date: {
          type: Sequelize.DATE,
          allowNull: true,
        },
        expiration_date: {
          type: Sequelize.DATE,
          allowNull: true,
          comment: "A product can be unvailable at a fixed date (example on Limited Run)",
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
        'product_website',
        ['website_id'],
        {
          name: 'fk_product_has_website_website1_idx',
        }
      ),
      await queryInterface.addIndex(
        'product_website',
        ['product_id'],
        {
          name: 'fk_product_has_website_product_idx',
        }
      ),
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return Promise.all([
      queryInterface.dropTable('product_website')
    ]);
  }
};
