import React from "react";
import TodoList from "./TodoList";

export default function Home() {
	return (
		<main className="container mx-auto mt-20 max-w-5xl">
			<h1 className="font-sans text-4xl font-light leading-4">Todo App</h1>

			<TodoList />
		</main>
	);
}
