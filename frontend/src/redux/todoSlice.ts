import { createSlice } from "@reduxjs/toolkit";
import { Todo, TodoState } from "./todoTypes";

const initialState: TodoState = {
	todos: [],
};

const todoSlice = createSlice({
	name: "todos",
	initialState,
	reducers: {
		addTodo: (state, action: { payload: string }) => {
			state.todos.push({
				id: Math.random().toString(),
				text: action.payload,
				completed: false,
			});
		},
		editTodo: (state, action: { payload: { id: string; text: string } }) => {
			const { id, text } = action.payload;
			const todoIndex = state.todos.findIndex((todo) => todo.id === id);
			if (todoIndex !== -1) {
				state.todos[todoIndex].text = text;
			}
		},
		deleteTodo: (state, action: { payload: string }) => {
			const id = action.payload;
			state.todos = state.todos.filter((todo) => todo.id !== id);
		},
		toggleCompleted: (state, action: { payload: string }) => {
			const id = action.payload;
			const todoIndex = state.todos.findIndex((todo) => todo.id === id);
			if (todoIndex !== -1) {
				state.todos[todoIndex].completed = !state.todos[todoIndex].completed;
			}
		},
	},
});

export const { addTodo, editTodo, deleteTodo, toggleCompleted } =
	todoSlice.actions;
export default todoSlice.reducer;
