"use client";
import React from "react";
import { useSelector, useDispatch } from "react-redux";
import { addTodo } from "../redux/todoSlice";
import Todo from "./Todo";
import { TodoState } from "../redux/todoTypes";

const TodoList: React.FC = () => {
	const dispatch = useDispatch();
	const todos = useSelector<TodoState>((state) => state.todos);

	const handleAddTodo = (event: React.FormEvent<HTMLFormElement>) => {
		event.preventDefault();
		const text = (event.target.elements.newTodo as HTMLInputElement).value;
		if (text) {
			dispatch(addTodo({ text }));
			(event.target.elements.newTodo as HTMLInputElement).value = "";
		}
	};

	return (
		<div className="py-3">
			<form onSubmit={handleAddTodo}>
				<input
					type="text"
					className="px-2 py-3 rounded-md border border-gray-100 focus:border-blue-500 outline-1 outline-gray-500 focus:outline-blue-800"
					name="newTodo"
					placeholder="Add a new todo"
				/>
				<button
					className="px-4 py-3 border-none rounded-md bg-blue-500 text-white ml-3"
					type="submit"
				>
					Add
				</button>
			</form>
			{todos?.length && (
				<ul>
					{todos.map((todo) => (
						<Todo key={todo.id} todo={todo} />
					))}
				</ul>
			)}
		</div>
	);
};

export default TodoList;
