// Simple fetch wrapper for Sanity queries
// This replaces the live query functionality for now to avoid client-side issues
import { client } from "./client";

// Simple sanityFetch function that works on both client and server
export const sanityFetch = async ({ query, params = {} }: { query: string; params?: Record<string, unknown> }) => {
  try {
    const data = await client.fetch(query, params);
    return { data };
  } catch (error) {
    console.error("Error fetching from Sanity:", error);
    throw error;
  }
};

// Placeholder SanityLive component for compatibility
export const SanityLive = () => null;
