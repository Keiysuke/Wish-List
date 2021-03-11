'use strict';
module.exports = {
  up: async (queryInterface, Sequelize) => {
    return Promise.all([
      await queryInterface.createTable('products', {
        id: {
          type: Sequelize.INTEGER(11).UNSIGNED,
          allowNull: false,
          primaryKey: true,
          autoIncrement: true,
        },
        label: {
          type: Sequelize.TEXT('long'),
          allowNull: false,
        },
        description: {
          type: Sequelize.TEXT('long'),
          allowNull: false,
        },
        limited_edition: {
          type: Sequelize.INTEGER(5),
          allowNull: false,
        },
        real_cost: {
          type: Sequelize.DECIMAL(10,2),
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
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return Promise.all([
      queryInterface.dropTable('products')
    ]);
  }
};
