'use strict';
module.exports = {
  up: async (queryInterface, Sequelize) => {
    return Promise.all([
      await queryInterface.createTable('product_states', {
        id: {
          type: Sequelize.INTEGER(1).UNSIGNED,
          allowNull: false,
          primaryKey: true,
          autoIncrement: true,
        },
        label: {
          type: Sequelize.STRING(45),
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
      queryInterface.dropTable('product_states')
    ]);
  }
};
