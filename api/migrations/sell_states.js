'use strict';
module.exports = {
  up: async (queryInterface, Sequelize) => {
    return Promise.all([
      await queryInterface.createTable('sell_states', {
        id: {
          type: Sequelize.INTEGER(1).UNSIGNED,
          allowNull: false,
          primaryKey: true,
          autoIncrement: true,
        },
        label: {
          type: Sequelize.STRING(100),
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
      queryInterface.dropTable('sell_states')
    ]);
  }
};
