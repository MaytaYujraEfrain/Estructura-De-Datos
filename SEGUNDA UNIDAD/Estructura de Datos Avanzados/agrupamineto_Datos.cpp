#include <iostream>
#include <vector>
#include <map>

// Estructura para representar un empleado
struct Employee {
    std::string name;
    int department;
    double salary;
};

// Función para agrupar empleados por departamento
void groupEmployeesByDepartment(const std::vector<Employee>& employees, std::vector<std::vector<Employee>>& groupedEmployees) {
    // Crear un mapa para almacenar los empleados por departamento
    std::map<int, std::vector<Employee>> departmentMap;

    // Agrupar empleados por departamento
    for (const auto& employee : employees) {
        departmentMap[employee.department].push_back(employee);
    }

    // Convertir el mapa a una matriz de vectores
    groupedEmployees.clear();
    for (const auto& pair : departmentMap) {
        groupedEmployees.push_back(pair.second);
    }
}

int main() {
    // Crear un vector de empleados
    std::vector<Employee> employees = {
        {"John", 1, 50000.0},
        {"Jane", 1, 60000.0},
        {"Bob", 2, 70000.0},
        {"Alice", 2, 55000.0},
        {"Mike", 3, 65000.0},
        {"Emma", 3, 75000.0},
        {"Tom", 1, 50000.0},
        {"Lily", 2, 60000.0},
        {"Sam", 3, 70000.0},
        {"Rachel", 1, 55000.0}
    };

    // Agrupar empleados por departamento
    std::vector<std::vector<Employee>> groupedEmployees;
    groupEmployeesByDepartment(employees, groupedEmployees);

    // Mostrar los empleados agrupados por departamento
    std::map<int, std::vector<Employee>> departmentMap;

    // Crear el mapa de nuevo para mostrar los departamentos correctamente
    for (const auto& employee : employees) {
        departmentMap[employee.department].push_back(employee);
    }

    for (const auto& pair : departmentMap) {
        std::cout << "Departamento " << pair.first << ":\n";
        for (const auto& employee : pair.second) {
            std::cout << "  " << employee.name << " - " << employee.salary << "\n";
        }
        std::cout << "\n";
    }

    return 0;
}
